# NapRockWeb Deployment (Ubuntu + Nginx)

This folder contains ready-to-run deployment files for production.

## 0) Prepare server

- Ubuntu 22.04+ VPS
- Domain already pointed to server IP
- Project cloned to `/var/www/naprockweb`

## 1) Install server dependencies

```bash
cd /var/www/naprockweb
bash deploy/01-server-setup.sh
```

## 2) Configure environment

```bash
cd /var/www/naprockweb
cp deploy/.env.production.example .env
nano .env
```

Set these before first deploy:
- `APP_URL` (use `https://est-monitoring.online`)
- `DB_*`
- `VITE_FIREBASE_*`

## 3) Deploy app

```bash
cd /var/www/naprockweb
bash deploy/02-app-deploy.sh
```

## 4) Enable Nginx + Supervisor

`deploy/nginx.naprockweb.conf` is already set to `est-monitoring.online`.

```bash
cd /var/www/naprockweb
bash deploy/04-enable-configs.sh
```

## 5) Enable HTTPS

`deploy/03-ssl.sh` is already set to `est-monitoring.online`.

```bash
cd /var/www/naprockweb
bash deploy/03-ssl.sh
```

## 6) Post-deploy checks

```bash
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo supervisorctl status
php artisan about
```

## Redeploy (new code)

```bash
cd /var/www/naprockweb
git pull
bash deploy/02-app-deploy.sh
```

## Notes

- Queue worker is enabled via Supervisor.
- This setup assumes Laravel serves Blade frontend + API in one app.
- If you use managed DB, only update `.env`; no local MySQL tuning required.
