import json
import os
import base64
from datetime import datetime, timezone
from pathlib import Path
from typing import Any
from uuid import uuid4

import firebase_admin
from dotenv import load_dotenv
from fastapi import FastAPI, File, Form, HTTPException, UploadFile
from firebase_admin import credentials, db, storage
from pydantic import BaseModel

# Load .env from same directory as app.py
load_dotenv(Path(__file__).resolve().parent / ".env")

app = FastAPI(title="NapRock Python Firebase API", version="1.0.0")


class SensorPayload(BaseModel):
    device_id: str
    sound_db: float
    temperature_c: float
    latitude: float
    longitude: float
    timestamp: str


def init_firebase() -> None:
    if firebase_admin._apps:
        return

    database_url = os.getenv("FIREBASE_DATABASE_URL")
    service_account_file = os.getenv("FIREBASE_SERVICE_ACCOUNT_FILE")
    service_account_json = os.getenv("FIREBASE_SERVICE_ACCOUNT_JSON")

    if not database_url:
        raise RuntimeError("FIREBASE_DATABASE_URL is required")

    # Prefer file-based credentials, fallback to JSON env var
    storage_bucket = os.getenv("FIREBASE_STORAGE_BUCKET")
    if service_account_file:
        file_path = Path(__file__).resolve().parent / service_account_file
        if not file_path.exists():
            raise RuntimeError(f"Service account file not found: {file_path}")
        service_account_info = json.loads(file_path.read_text(encoding="utf-8"))
        cred = credentials.Certificate(str(file_path))
    elif service_account_json:
        try:
            service_account_info = json.loads(service_account_json)
        except json.JSONDecodeError as exc:
            raise RuntimeError("FIREBASE_SERVICE_ACCOUNT_JSON must be valid JSON") from exc
        cred = credentials.Certificate(service_account_info)
    else:
        raise RuntimeError("FIREBASE_SERVICE_ACCOUNT_FILE or FIREBASE_SERVICE_ACCOUNT_JSON is required")

    project_id = os.getenv("FIREBASE_PROJECT_ID") or service_account_info.get("project_id")
    if project_id:
        os.environ["FIREBASE_PROJECT_ID"] = project_id

    if not storage_bucket:
        if project_id:
            storage_bucket = f"{project_id}.appspot.com"

    options: dict[str, str] = {"databaseURL": database_url}
    if storage_bucket:
        options["storageBucket"] = storage_bucket

    firebase_admin.initialize_app(cred, options)


@app.on_event("startup")
def startup_event() -> None:
    init_firebase()


@app.get("/health")
def health() -> dict[str, str]:
    return {"status": "ok"}


@app.get("/sensor/latest")
def get_latest_sensor() -> dict[str, Any]:
    ref = db.reference("devices/esp32-001/latest")
    snapshot = ref.get()
    return {"data": snapshot}


@app.post("/sensor/latest")
def write_latest_sensor(payload: SensorPayload) -> dict[str, str]:
    try:
        ref = db.reference(f"devices/{payload.device_id}/latest")
        ref.set(payload.model_dump())
        return {"status": "written"}
    except Exception as exc:
        raise HTTPException(status_code=500, detail=str(exc)) from exc


@app.post("/audio/upload")
async def upload_audio(
    device_id: str = Form(...),
    timestamp: str | None = Form(None),
    audio_file: UploadFile = File(...),
) -> dict[str, Any]:
    content_type = (audio_file.content_type or "").lower()
    if content_type and not content_type.startswith("audio/"):
        raise HTTPException(status_code=400, detail="audio_file must be an audio content type")

    ext = Path(audio_file.filename or "audio.wav").suffix or ".wav"
    safe_device = "".join(ch for ch in device_id if ch.isalnum() or ch in ("-", "_")) or "unknown-device"
    effective_ts = timestamp or datetime.now(timezone.utc).isoformat()
    object_name = f"raw-audio/{safe_device}/{datetime.now(timezone.utc).strftime('%Y%m%dT%H%M%SZ')}-{uuid4().hex}{ext}"

    def _upload_blob(target_bucket: str | None, data: bytes) -> tuple[Any, Any]:
        bucket_ref = storage.bucket(target_bucket) if target_bucket else storage.bucket()
        blob_ref = bucket_ref.blob(object_name)
        blob_ref.upload_from_string(data, content_type=audio_file.content_type or "application/octet-stream")
        return bucket_ref, blob_ref

    try:
        configured_bucket = os.getenv("FIREBASE_STORAGE_BUCKET") or None
        project_id = os.getenv("FIREBASE_PROJECT_ID") or ""

        audio_bytes = await audio_file.read()
        if not audio_bytes:
            raise HTTPException(status_code=400, detail="audio_file is empty")

        try:
            bucket, _ = _upload_blob(configured_bucket, audio_bytes)
        except Exception as primary_exc:
            primary_message = str(primary_exc).lower()
            fallback_bucket = f"{project_id}.appspot.com" if project_id else ""
            if (
                "bucket does not exist" not in primary_message
                or not fallback_bucket
                or (configured_bucket or "") == fallback_bucket
            ):
                bucket = None
            else:
                try:
                    bucket, _ = _upload_blob(fallback_bucket, audio_bytes)
                except Exception:
                    bucket = None

        if not bucket:
            encoded = base64.b64encode(audio_bytes).decode("ascii")
            inline_metadata = {
                "device_id": safe_device,
                "timestamp": effective_ts,
                "filename": audio_file.filename,
                "content_type": audio_file.content_type,
                "size_bytes": len(audio_bytes),
                "audio_base64": encoded,
                "storage_path": None,
                "bucket": None,
                "uploaded_at": datetime.now(timezone.utc).isoformat(),
                "mode": "realtime-db-inline-fallback",
            }
            db.reference(f"devices/{safe_device}/audio/latest").set(inline_metadata)
            db.reference(f"devices/{safe_device}/audio/history").push(inline_metadata)
            response_audio = {k: v for k, v in inline_metadata.items() if k != "audio_base64"}
            response_audio["audio_base64"] = "stored_in_db"
            return {"status": "uploaded-inline", "audio": response_audio}

        metadata = {
            "device_id": safe_device,
            "timestamp": effective_ts,
            "filename": audio_file.filename,
            "content_type": audio_file.content_type,
            "size_bytes": len(audio_bytes),
            "storage_path": object_name,
            "bucket": bucket.name,
            "uploaded_at": datetime.now(timezone.utc).isoformat(),
        }

        db.reference(f"devices/{safe_device}/audio/latest").set(metadata)
        db.reference(f"devices/{safe_device}/audio/history").push(metadata)

        return {"status": "uploaded", "audio": metadata}
    except HTTPException:
        raise
    except Exception as exc:
        raise HTTPException(
            status_code=500,
            detail=f"Audio upload failed: {exc}. Check FIREBASE_STORAGE_BUCKET and ensure Firebase Storage is enabled.",
        ) from exc
