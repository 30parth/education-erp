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

echo "==> Configuring Nginx port..."
export PORT=${PORT:-80}
envsubst '${PORT}' < /etc/nginx/nginx.conf.template > /etc/nginx/nginx.conf

echo "==> Starting supervisord..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf