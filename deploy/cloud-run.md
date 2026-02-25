# Deploy Laravel (PHP web) to Google Cloud Run + Custom Domain

This repo includes a `Dockerfile` that runs **nginx + php-fpm** on port `8080` (compatible with Cloud Run).

## 1) Prerequisites

- A Google Cloud project (billing enabled)
- Cloud Run API enabled
- A domain (e.g. `est-monitoring.online`) on Namecheap/Spaceship/etc.

## 2) Deploy from source (Cloud Shell)

Open Google Cloud Console → Cloud Shell, then run inside your repo folder:

```bash
gcloud run deploy naprockweb-web \
  --source . \
  --region asia-southeast1 \
  --allow-unauthenticated \
  --set-env-vars APP_ENV=production,APP_DEBUG=false,LOG_CHANNEL=stderr,SESSION_DRIVER=file,CACHE_STORE=file,QUEUE_CONNECTION=sync \
  --set-env-vars APP_URL=https://est-monitoring.online
```

Required env vars you must set (one way or another):

- `APP_KEY` (generate locally with `php artisan key:generate --show`)

## 3) Map the custom domain (Spaceship)

Cloud Run → your service → **Custom domains** → **Add mapping**:

- Add `est-monitoring.online` → select your service

Google will show DNS records to add. For an apex/root domain, it commonly asks for multiple `A` records.

Add exactly what Google shows in your domain provider DNS.

In Spaceship DNS, add the records with these rules:

- host/name `@` for root domain (`est-monitoring.online`)
- host/name `www` for `www.est-monitoring.online` if you map it
- remove conflicting old `A`, `AAAA`, or `CNAME` records for the same host
- keep only the records provided by Cloud Run mapping

Then wait DNS propagation (can take a few minutes up to 24h), and open:

- `https://est-monitoring.online` (not only `https://<service>-<hash>.run.app`)

## 4) After domain works

- Set `APP_URL=https://est-monitoring.online`
- If your Laravel app calls your Python API, set something like:
  - `PYTHON_API_URL=https://api.est-monitoring.online`

## 5) Auto deploy on push (like Vercel main)

This repo now includes GitHub Actions workflow:

- `.github/workflows/deploy-cloud-run.yml`

It deploys automatically when you push to `main`.

### Required GitHub repository secrets

Add these in GitHub → Settings → Secrets and variables → Actions:

- `GCP_PROJECT_ID` → your GCP project id (example: `eco-system-translator`)
- `GCP_WORKLOAD_IDENTITY_PROVIDER` → Workload Identity Provider full resource name
- `GCP_SERVICE_ACCOUNT` → deploy service account email
- `APP_KEY` → Laravel app key (example: `base64:...`)

### Recommended authentication method

Use Workload Identity Federation (OIDC) for GitHub Actions (no JSON key file).

At minimum, the deploy service account needs roles like:

- `roles/run.admin`
- `roles/iam.serviceAccountUser`
- `roles/cloudbuild.builds.editor`
- `roles/artifactregistry.writer`

After this, every push to `main` redeploys Cloud Run automatically.

## 6) Python server + existing Firebase

This repo includes a minimal Python API at:

- `python_server/app.py`

Install and run locally:

```bash
cd python_server
python -m venv .venv
source .venv/bin/activate
pip install -r requirements.txt
cp .env.example .env
uvicorn app:app --reload --port 9001
```

Endpoints:

- `GET /health`
- `GET /sensor/latest`
- `POST /sensor/latest`

Required environment variables for Python server:

- `FIREBASE_DATABASE_URL`
- `FIREBASE_SERVICE_ACCOUNT_JSON` (service account JSON as a single-line string)

If your Laravel app needs this API, set:

- `PYTHON_API_URL=http://127.0.0.1:9001` (local)
- or `https://api.est-monitoring.online` (production)

## Notes

- Cloud Run filesystem is ephemeral. Don't store persistent uploads in `storage/app` unless you use a persistent storage solution.
- For logs, keep `LOG_CHANNEL=stderr`.

## Troubleshooting

### Tailwind utilities not applied (unstyled page)

Usually means your Vite build assets are not being served correctly.

Check these quickly:

```bash
gcloud run services logs read naprockweb-web --region asia-southeast1 --limit 200
curl -I https://est-monitoring.online/build/manifest.json
```

If `manifest.json` or `/build/assets/*.css` returns `404`, redeploy so Cloud Run image includes fresh Vite build.

After redeploy, hard refresh browser (`Ctrl + F5`).

### 502 Bad Gateway

Usually means **nginx can't reach php-fpm**. This repo configures php-fpm on `127.0.0.1:9000` and nginx forwards PHP requests there.

To view logs:

```bash
gcloud run services logs read naprockweb-web --region asia-southeast1 --limit 200
```
