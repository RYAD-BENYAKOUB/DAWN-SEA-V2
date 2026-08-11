# Étape 1 : Construction des assets front-end (Node.js)
FROM node:20-alpine AS build-node
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Étape 2 : Image finale avec PHP 8.3 et Apache
FROM php:8.3-apache

# 1. Installation des dépendances système requises (PostgreSQL, zip, etc.)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Configuration d'Apache pour pointer vers le dossier "public" de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Activation du module rewrite d'Apache (nécessaire pour le routage Laravel)
RUN a2enmod rewrite

# 4. Ajustement du port pour Render (Render utilise la variable d'environnement $PORT, par défaut 10000)
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-available/000-default.conf

# 5. Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 6. Copier les fichiers du projet Laravel
COPY . .

# 7. Copier les assets compilés (Vite) depuis l'étape 1
COPY --from=build-node /app/public/build ./public/build

# 8. Installation des dépendances PHP
RUN composer install --no-dev --no-interaction --optimize-autoloader

# 9. Attribution des permissions pour Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Mise en cache de la configuration Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache