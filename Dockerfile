FROM php:8.2-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip git curl libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier le projet
COPY . .

# Donner les droits (à adapter si nécessaire)
RUN chown -R www-data:www-data /var/www/html

# Installer les dépendances PHP
RUN composer install

EXPOSE 9000
CMD ["php-fpm"]
