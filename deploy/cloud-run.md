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
  --set-env-vars APP_ENV=production,APP_DEBUG=false,LOG_CHANNEL=stderr \
  --set-env-vars APP_URL=https://est-monitoring.online
```

Required env vars you must set (one way or another):
- `APP_KEY` (generate locally with `php artisan key:generate --show`)

## 3) Map the custom domain

Cloud Run → your service → **Custom domains** → **Add mapping**:

- Add `est-monitoring.online` → select your service

Google will show DNS records to add. For an apex/root domain, it commonly asks for multiple `A` records.

Add exactly what Google shows in your domain provider DNS.

## 4) After domain works

- Set `APP_URL=https://est-monitoring.online`
- If your Laravel app calls your Python API, set something like:
  - `PYTHON_API_URL=https://api.est-monitoring.online`

## Notes

- Cloud Run filesystem is ephemeral. Don't store persistent uploads in `storage/app` unless you use a persistent storage solution.
- For logs, keep `LOG_CHANNEL=stderr`.
