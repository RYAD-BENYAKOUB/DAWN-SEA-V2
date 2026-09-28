#!/bin/bash
set -e

echo "=== DAWN & SEA V2 — Runtime Startup ==="

# 1. Create storage directories if they don't exist
mkdir -p /var/www/html/storage/framework/{sessions,views,cache/data}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# 2. Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 3. Create storage symlink (idempotent)
php artisan storage:link --force 2>/dev/null || true

# 4. Cache configuration (NOW that Railway env vars are available)
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Reset Spatie permission cache
php artisan permission:cache-reset 2>/dev/null || true

# 6. Runtime Port Configuration
export PORT="${PORT:-8080}"

# Validate PORT is numeric
if ! [[ "$PORT" =~ ^[0-9]+$ ]]; then
    echo "Error: PORT is not numeric: $PORT"
    exit 1
fi

echo "=== Railway PORT ==="
echo "$PORT"

# Update Apache configuration for the runtime port
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# 7. Diagnostics & Runtime Enforcements
echo "=== RUNTIME ACTIVE MPMs ==="
find /etc/apache2/mods-enabled -maxdepth 1 -type l -name 'mpm_*' -printf '%f -> %l\n' | sort || true

echo "=== RUNTIME MPM LOAD DIRECTIVES ==="
grep -RniE '^[[:space:]]*LoadModule[[:space:]]+mpm_' /etc/apache2 2>/dev/null || true

# Enforce the runtime state before booting Apache
rm -f /etc/apache2/mods-enabled/mpm_event.load
rm -f /etc/apache2/mods-enabled/mpm_event.conf
rm -f /etc/apache2/mods-enabled/mpm_worker.load
rm -f /etc/apache2/mods-enabled/mpm_worker.conf

if [ ! -L /etc/apache2/mods-enabled/mpm_prefork.load ]; then
    ln -s ../mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
fi

echo "=== Apache config test ==="
apache2ctl -t

echo "=== Starting Apache ==="
exec apache2-foreground
