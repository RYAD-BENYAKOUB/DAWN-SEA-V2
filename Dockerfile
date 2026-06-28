FROM richarvey/nginx-php-fpm:latest

# Variables d'environnement
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Copie du code source
COPY . /var/www/html

WORKDIR /var/www/html

# Installation des dépendances Composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Génération de la clé et cache Laravel
RUN php artisan config:clear
RUN php artisan route:cache
RUN php artisan view:cache

# Permissions correctes
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80