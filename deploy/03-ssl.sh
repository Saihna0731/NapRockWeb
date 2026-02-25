#!/usr/bin/env bash
set -euo pipefail

DOMAIN="est-monitoring.online"
WWW_DOMAIN="www.est-monitoring.online"

sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d "$DOMAIN" -d "$WWW_DOMAIN"
