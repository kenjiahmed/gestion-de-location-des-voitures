# Dockerfile pour l'application Symfony
FROM php:8.3-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    zip \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip opcache intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuration PHP pour la production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/custom.ini $PHP_INI_DIR/conf.d/custom.ini

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers de dépendances
COPY composer.json composer.lock symfony.lock ./

# Installation des dépendances (sans scripts pour éviter les erreurs)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist && \
    composer clear-cache

# Copie de tous les fichiers de l'application
COPY . .

# Finalisation de l'autoloader
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

# Permissions
RUN chown -R www-data:www-data /var/www/html/var

# Exposition du port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]

