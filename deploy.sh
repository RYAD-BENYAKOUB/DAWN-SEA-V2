#!/bin/bash
# =============================================================================
# DAWN & SEA V2 — deploy.sh
# =============================================================================
# This script is intended for NON-DOCKER deployments only.
# When using Docker (Railway), the Dockerfile and docker-entrypoint.sh
# handle build and runtime steps respectively.
#
# For bare-metal or VM deployments:
#   1. Run this script once after deploying new code
#   2. Environment variables must be set BEFORE running this script
# =============================================================================

set -e

echo "=== DAWN & SEA V2 — Deployment Script ==="

# 1. Install PHP dependencies (production only)
echo "[1/7] Installing Composer dependencies..."
composer install --no-dev --no-interaction --optimize-autoloader

# 2. Build frontend assets
echo "[2/7] Building frontend assets..."
npm ci --ignore-scripts
npm run build

# 3. Clear old caches first
echo "[3/7] Clearing old caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 4. Rebuild caches with current environment
echo "[4/7] Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 5. Storage symlink
echo "[5/7] Setting up storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# 6. Spatie permissions cache
echo "[6/7] Resetting Spatie permissions cache..."
php artisan permission:cache-reset 2>/dev/null || true

# 7. Permissions
echo "[7/7] Setting directory permissions..."
chmod -R 775 storage bootstrap/cache

echo "=== Deployment completed successfully! ==="
echo ""
echo "NOTE: Database migrations are NOT run automatically."
echo "      Run 'php artisan migrate --force' manually after verifying"
echo "      migration compatibility with the production database."
