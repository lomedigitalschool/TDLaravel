FROM php:8.3-cli

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    zip unzip curl sqlite3 libsqlite3-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier les fichiers Laravel
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Créer le fichier SQLite si manquant
RUN mkdir -p database && touch database/database.sqlite && chmod 777 database/database.sqlite
