#!/usr/bin/env bash
set -euo pipefail

# Ensure Laravel runtime paths exist in Cloud Run (ephemeral filesystem)
mkdir -p /var/www/storage/framework/views
mkdir -p /var/www/storage/framework/cache/data
mkdir -p /var/www/storage/framework/sessions
mkdir -p /var/www/storage/logs
mkdir -p /var/www/bootstrap/cache

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R ug+rwX /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM in the background
php-fpm -D

# Start nginx in the foreground
exec nginx -g "daemon off;"
