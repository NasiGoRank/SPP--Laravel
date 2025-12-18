# Stage 1: Build Aset Vite
FROM node:18-alpine AS build-stage
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Server PHP & Nginx
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache nginx libpng-dev libzip-dev zip unzip git icu-dev

# Install PHP extensions
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo_mysql bcmath gd zip intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Copy built assets from Stage 1
COPY --from=build-stage /app/public/build ./public/build

# Install PHP production dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup Nginx
COPY nginx.conf /etc/nginx/http.d/default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Start command
CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php-fpm -D && nginx -g 'daemon off;'"]
