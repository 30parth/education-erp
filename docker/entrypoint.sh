#!/bin/bash
set -e

echo "Starting Laravel Entrypoint..."

# Wait for database (optional but useful if connecting to an external DB)
# In Render, environment variables will be available.

# Create SQLite database if using SQLite and it does not exist
if [ "$DB_CONNECTION" = "sqlite" ]; then
    if [ ! -f /var/www/html/database/database.sqlite ]; then
        echo "Creating SQLite database file..."
        touch /var/www/html/database/database.sqlite
    fi
    chown www-data:www-data /var/www/html/database/database.sqlite
fi

# Run database migrations
# Make sure to run with --force in production so it doesn't prompt for confirmation
echo "Running migrations..."
php artisan migrate --force

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

echo "Starting Apache..."
exec "$@"
