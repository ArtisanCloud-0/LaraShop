# syntax=docker/dockerfile:1

# ============================================================
# Stage 1: Install PHP dependencies
# ============================================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# ============================================================
# Stage 2: Build Vite / Tailwind assets
# ============================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


# ============================================================
# Stage 3: Production application
# ============================================================
FROM php:8.4-fpm-bookworm AS app

ARG DEBIAN_FRONTEND=noninteractive

# ------------------------------------------------------------
# System packages
# ------------------------------------------------------------
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        gettext-base \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libsqlite3-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pdo_sqlite \
        xml \
        zip \
    && rm -rf /var/lib/apt/lists/*


# ------------------------------------------------------------
# Laravel application
# ------------------------------------------------------------
WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor

COPY --from=frontend /app/public/build ./public/build

COPY . .


# ------------------------------------------------------------
# Laravel writable directories
# ------------------------------------------------------------
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data \
        storage \
        bootstrap/cache \
    && chmod -R ug+rwx \
        storage \
        bootstrap/cache


# ------------------------------------------------------------
# Nginx
# ------------------------------------------------------------
COPY docker/nginx/default.conf.template \
    /etc/nginx/templates/default.conf.template


# ------------------------------------------------------------
# Supervisor
# ------------------------------------------------------------
COPY docker/supervisor/supervisord.conf \
    /etc/supervisor/conf.d/supervisord.conf


# ------------------------------------------------------------
# Laravel entrypoint
# ------------------------------------------------------------
COPY docker/entrypoint.sh \
    /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh \
    && rm -f /etc/nginx/sites-enabled/default


# ------------------------------------------------------------
# Runtime environment
# ------------------------------------------------------------
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV PORT=10000

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]