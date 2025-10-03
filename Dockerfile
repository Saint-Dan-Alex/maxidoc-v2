FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers du projet
COPY . .

# Mettre à jour et installer les dépendances
RUN composer update --no-scripts --no-autoloader && \
    composer install --no-scripts --no-autoloader && \
    composer dump-autoload --optimize

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/storage
RUN chmod -R 775 /var/www/storage

# Exposer le port 9000
EXPOSE 9000

# Lancer le serveur PHP-FPM
CMD ["php-fpm"]
