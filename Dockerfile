FROM php:8.3-fpm

# 1. Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

    # ✅ Modifier www.conf pour écouter sur 0.0.0.0
RUN sed -i 's|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|' /usr/local/etc/php-fpm.d/www.conf

# 2. Copier Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Définir le répertoire de travail
WORKDIR /var/www

# 4. Copier tous les fichiers du projet
COPY . .

# 5. Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Gérer les permissions Laravel
RUN mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache \
    resources/views \
    && echo "<h1>Vue temporaire</h1>" > resources/views/_temp.blade.php \
    && chown -R www-data:www-data storage bootstrap/cache resources/views \
    && chmod -R 775 storage bootstrap/cache

# 7. Compiler les fichiers Laravel si .env est présent
RUN test -f .env && php artisan config:cache && php artisan route:cache && php artisan view:cache || echo ".env non présent, skipping artisan cache"

# Étape 9 : Exposer le port PHP-FPM
EXPOSE 9000

# 8. Démarrer PHP-FPM
CMD ["php-fpm"]
