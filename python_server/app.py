import json
import os
from typing import Any

import firebase_admin
from fastapi import FastAPI, HTTPException
from firebase_admin import credentials, db
from pydantic import BaseModel

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
    service_account_json = os.getenv("FIREBASE_SERVICE_ACCOUNT_JSON")

    if not database_url:
        raise RuntimeError("FIREBASE_DATABASE_URL is required")
    if not service_account_json:
        raise RuntimeError("FIREBASE_SERVICE_ACCOUNT_JSON is required")

    try:
        service_account_info = json.loads(service_account_json)
    except json.JSONDecodeError as exc:
        raise RuntimeError("FIREBASE_SERVICE_ACCOUNT_JSON must be valid JSON") from exc

    cred = credentials.Certificate(service_account_info)
    firebase_admin.initialize_app(cred, {"databaseURL": database_url})


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
