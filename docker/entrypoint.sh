#!/usr/bin/env bash
set -euo pipefail

# Start PHP-FPM in the background
php-fpm -D

# Start nginx in the foreground
exec nginx -g "daemon off;"
