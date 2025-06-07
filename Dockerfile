FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev unzip zip libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

CMD php artisan serve --host=0.0.0.0 --port=9000
