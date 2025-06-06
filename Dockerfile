FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copier uniquement les fichiers nécessaires pour installer les dépendances
COPY composer.json composer.lock ./

RUN composer install --no-dev --prefer-dist --no-scripts --no-autoloader

# Copier le reste du code
COPY . .

RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www
RUN apt-get update && apt-get install -y iputils-ping netcat-traditional postgresql-client

# Pas de php artisan serve en production !
CMD ["php-fpm"]
