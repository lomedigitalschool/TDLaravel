FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpq-dev libzip-dev unzip zip libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# (Optionnel) Installer Node.js si tu veux builder Tailwind
# RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
#     && apt-get install -y nodejs \
#     && npm ci && npm run build

# Expose port (utile pour 'artisan serve')
EXPOSE 8000

#CMD ["php-fpm"]
CMD php artisan serve --host=0.0.0.0 --port=8000
