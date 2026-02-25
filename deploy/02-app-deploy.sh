#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/naprockweb"
PHP_BIN="php"
COMPOSER_BIN="composer"

cd "$APP_DIR"

$COMPOSER_BIN install --no-dev --optimize-autoloader
npm ci
npm run build

if [ ! -f .env ]; then
  cp deploy/.env.production.example .env
  echo "Created .env from deploy/.env.production.example"
  echo "Update .env values before continuing."
  exit 1
fi

$PHP_BIN artisan key:generate --force
$PHP_BIN artisan migrate --force
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

sudo chown -R www-data:www-data "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
sudo chmod -R ug+rwx "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"

sudo systemctl restart php8.2-fpm
sudo systemctl reload nginx

echo "Deploy complete."
