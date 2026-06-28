FROM richarvey/nginx-php-fpm:latest

# Configuration de l'environnement de production
ENV AUDIT_DATA_ALERTER=false
ENV MIX_PROD=true
ENV WEBROOT=/var/www/html/public

# Copie du code source
COPY . /var/www/html

# Installation des dépendances avec Composer
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Configuration des permissions pour Laravel
RUN chown -R nw:nw /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port par défaut de Render
EXPOSE 80