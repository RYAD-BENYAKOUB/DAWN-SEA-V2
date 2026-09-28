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

# 6. Default PORT if not set by Railway
export PORT="${PORT:-8080}"

echo "=== Starting Apache on port ${PORT} ==="
exec apache2-foreground
