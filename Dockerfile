# Étape 1 : Image de base officielle PHP avec extensions requises
FROM php:8.3-fpm as base

# Étape 2 : Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Étape 3 : Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Étape 4 : Définir le répertoire de travail
WORKDIR /var/www

# Étape 5 : Copier les fichiers de l'application
COPY . .

# Étape 6 : Copier le fichier .env.example en .env s’il n’existe pas
RUN cp .env.example .env

# Étape 7 : Installer les dépendances PHP avec Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

RUN rm -rf bootstrap/cache/*.php

# Étape 8 : Donner les bonnes permissions (important pour storage et bootstrap/cache)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache
    
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Étape 11 : Exposer le port du conteneur
EXPOSE 9000

# Étape 12 : Commande de démarrage de PHP-FPM
CMD ["php-fpm"]
