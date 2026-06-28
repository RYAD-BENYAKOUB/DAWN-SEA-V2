FROM richarvey/nginx-php-fpm:latest

ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

COPY . /var/www/html

WORKDIR /var/www/html

# Installation Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Compilation Vite
RUN npm install && npm run build && rm -rf node_modules

# Installation PHP
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Cache Laravel
RUN php artisan config:clear
RUN php artisan route:cache
RUN php artisan view:cache

# Permissions
RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80