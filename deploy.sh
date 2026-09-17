#!/bin/bash

# Exit on any error
set -e

echo "Starting deployment for Dawn & Sea..."

# 1. Install Composer dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 2. Build Frontend Assets
echo "Building frontend assets..."
npm ci
npm run build

# 3. Clear and regenerate caches
echo "Regenerating caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 4. Database migrations
echo "Running database migrations..."
php artisan migrate --force

# 5. Storage linking
echo "Setting up storage symlink..."
php artisan storage:link || true

# 6. Spatie Permissions caching
echo "Resetting Spatie permissions cache..."
php artisan permission:cache-reset

# 7. Setting folder permissions (Optional, adjust based on server user/group)
echo "Setting basic directory permissions..."
chmod -R 775 storage bootstrap/cache

echo "Deployment completed successfully!"
