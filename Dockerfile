# syntax=docker/dockerfile:1

### 1) Build frontend assets (Vite)
FROM node:20-bookworm-slim AS nodebuild
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm ci
RUN npm run build

### 2) Install PHP dependencies
FROM composer:2 AS composerbuild
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
  --no-dev \
  --prefer-dist \
  --no-interaction \
  --no-progress \
  --optimize-autoloader \
  --no-scripts

### 3) Runtime (nginx + php-fpm in one container)
FROM php:8.2-fpm-bookworm AS runtime

# System deps
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    nginx \
    supervisor \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libicu-dev \
  && rm -rf /var/lib/apt/lists/*

# PHP extensions commonly needed by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    intl \
    gd \
  && php -v

# Configure nginx + supervisord
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www

# App source
COPY . /var/www

# Vendor + built assets
COPY --from=composerbuild /app/vendor /var/www/vendor
COPY --from=nodebuild /app/public/build /var/www/public/build

# Permissions for Laravel cache/storage
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

# Cloud Run uses $PORT (default 8080)
ENV PORT=8080
EXPOSE 8080

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
