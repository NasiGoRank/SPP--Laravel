# Stage 1: Build Aset Vite
FROM node:18-alpine AS build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Aplikasi PHP
FROM php:8.2-fpm-alpine

# Install ekstensi yang dibutuhkan Laravel & Livewire
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    icu-dev

RUN docker-php-ext-install pdo_mysql bcmath gd zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Ambil hasil build Vite dari Stage 1
COPY --from=build-stage /app/public/build ./public/build

# Install dependency PHP tanpa development tools
RUN composer install --no-dev --optimize-autoloader

# Setup Nginx Config
COPY nginx.conf /etc/nginx/http.d/default.conf

# Beri izin akses folder storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Jalankan Nginx & PHP-FPM saat container start
CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php-fpm -D && nginx -g 'daemon off;'"]
