#!/usr/bin/env bash
set -euo pipefail

PHP_VERSION="8.2"

sudo apt update
sudo apt install -y nginx mysql-server unzip git curl supervisor software-properties-common

curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install -y \
  php${PHP_VERSION}-fpm \
  php${PHP_VERSION}-cli \
  php${PHP_VERSION}-mysql \
  php${PHP_VERSION}-mbstring \
  php${PHP_VERSION}-xml \
  php${PHP_VERSION}-curl \
  php${PHP_VERSION}-zip \
  php${PHP_VERSION}-bcmath

php -v
node -v
npm -v
nginx -v
