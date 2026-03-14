#!/bin/bash
set -e

echo "==> Creating storage symlink..."
php artisan storage:link --force

echo "==> Caching Laravel config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf