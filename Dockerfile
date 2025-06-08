FROM php:8.3-fpm

# 1. Installer les dépendances système et extensions PHP
RUN apt-get update && apt-get install -y \
    git curl unzip zip libpng-dev libonig-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# 2. Copier Composer depuis l'image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3. Définir le répertoire de travail
WORKDIR /var/www

# 4. Copier tous les fichiers du projet
COPY . .

# 5. Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Créer les dossiers nécessaires et gérer les permissions Laravel
RUN mkdir -p \
    storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 7. Compiler les fichiers de configuration Laravel (nécessite un .env valide déjà copié)
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 8. Exposer le port de l'application Laravel
EXPOSE 8000

# 9. Démarrer Laravel avec le serveur intégré PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
