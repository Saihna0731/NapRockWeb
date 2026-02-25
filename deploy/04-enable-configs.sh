#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/naprockweb"

sudo cp "$APP_DIR/deploy/nginx.naprockweb.conf" /etc/nginx/sites-available/naprockweb
sudo ln -sfn /etc/nginx/sites-available/naprockweb /etc/nginx/sites-enabled/naprockweb
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx

sudo cp "$APP_DIR/deploy/supervisor.laravel-worker.conf" /etc/supervisor/conf.d/naprockweb-worker.conf
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl status

echo "Nginx + Supervisor configs applied."
