# =============================================================================
# DAWN & SEA V2 — Production Dockerfile for Railway + Supabase
# =============================================================================

# Stage 1: Build frontend assets (Vite + Tailwind)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
RUN npm run build

# Stage 2: PHP production image
FROM php:8.4-apache

# 1. Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    zip \
    unzip \
    ca-certificates \
    && docker-php-ext-install pdo pdo_pgsql opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Configure OPcache for production
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini

# 3. Configure PHP for production
RUN { \
    echo 'expose_php=Off'; \
    echo 'display_errors=Off'; \
    echo 'log_errors=On'; \
    echo 'error_log=/dev/stderr'; \
    echo 'upload_max_filesize=10M'; \
    echo 'post_max_size=12M'; \
    echo 'memory_limit=256M'; \
    } > /usr/local/etc/php/conf.d/production.ini

# 4. Configure Apache — document root to Laravel's public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Enable required Apache modules and perform HARD DETERMINISTIC MPM CLEANUP
RUN set -eux; \
    a2dismod mpm_event mpm_worker mpm_itk || true; \
    rm -f /etc/apache2/mods-enabled/mpm_event.load; \
    rm -f /etc/apache2/mods-enabled/mpm_event.conf; \
    rm -f /etc/apache2/mods-enabled/mpm_worker.load; \
    rm -f /etc/apache2/mods-enabled/mpm_worker.conf; \
    rm -f /etc/apache2/mods-enabled/mpm_itk.load; \
    rm -f /etc/apache2/mods-enabled/mpm_itk.conf; \
    rm -f /etc/apache2/mods-enabled/mpm_prefork.load; \
    rm -f /etc/apache2/mods-enabled/mpm_prefork.conf; \
    a2enmod mpm_prefork rewrite headers; \
    echo "=== FINAL MPM STATE ==="; \
    find /etc/apache2/mods-enabled -maxdepth 1 -type l -name 'mpm_*' -printf '%f -> %l\n' | sort; \
    echo "=== MPM LOAD DIRECTIVES ==="; \
    grep -RniE '^[[:space:]]*LoadModule[[:space:]]+mpm_' /etc/apache2 2>/dev/null || true; \
    MPM_COUNT="$(find /etc/apache2/mods-enabled -maxdepth 1 -type l -name 'mpm_*.load' | wc -l)"; \
    if [ "$MPM_COUNT" -ne 1 ]; then \
        echo "ERROR: Expected exactly 1 active Apache MPM, found $MPM_COUNT"; \
        find /etc/apache2/mods-enabled -maxdepth 1 -type l -name 'mpm_*' -ls; \
        exit 1; \
    fi; \
    if [ ! -e /etc/apache2/mods-enabled/mpm_prefork.load ]; then \
        echo "ERROR: mpm_prefork is not enabled"; \
        exit 1; \
    fi; \
    echo "Apache MPM validation passed: mpm_prefork only."; \
    apache2ctl -t

# 6. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 8. Copy composer files and install PHP dependencies first (layer caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --optimize-autoloader --no-scripts

# 9. Copy the full Laravel project
COPY . .

# 10. Re-run composer scripts (post-autoload-dump, package discovery)
RUN composer dump-autoload --optimize

# 11. Copy compiled frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# 12. Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 13. Copy the runtime entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# NOTE: config:cache, route:cache, and view:cache are run at RUNTIME
# in the entrypoint script, AFTER Railway injects environment variables.

EXPOSE 8080

CMD ["/usr/local/bin/docker-entrypoint.sh"]