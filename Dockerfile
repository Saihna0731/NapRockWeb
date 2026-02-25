# syntax=docker/dockerfile:1

### 1) Build frontend assets (Vite)
FROM node:20-bookworm-slim AS nodebuild
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY .env.example .env.production
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

# Cloud Run-friendly php-fpm (nginx -> 127.0.0.1:9000)
RUN sed -i 's|^listen = .*|listen = 127.0.0.1:9000|' /usr/local/etc/php-fpm.d/www.conf \
  && { \
    grep -q '^listen.allowed_clients' /usr/local/etc/php-fpm.d/www.conf \
      && sed -i 's|^listen.allowed_clients = .*|listen.allowed_clients = 127.0.0.1|' /usr/local/etc/php-fpm.d/www.conf \
      || echo 'listen.allowed_clients = 127.0.0.1' >> /usr/local/etc/php-fpm.d/www.conf; \
  }

# Send PHP errors to stderr (shows up in Cloud Run logs)
RUN { \
    echo 'log_errors=On'; \
    echo 'error_log=/proc/self/fd/2'; \
  } > /usr/local/etc/php/conf.d/cloudrun-logging.ini

# Configure nginx + supervisord
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

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
  LOG_CHANNEL=stderr \
  SESSION_DRIVER=file \
  CACHE_STORE=file \
  QUEUE_CONNECTION=sync

# Cloud Run uses $PORT (default 8080)
ENV PORT=8080
EXPOSE 8080

CMD ["/usr/local/bin/entrypoint"]
