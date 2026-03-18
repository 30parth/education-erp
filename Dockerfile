# Stage 1: Build PHP Dependencies
FROM composer:2.7 as vendor
WORKDIR /app

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs \
    --no-scripts

# Copy application files
COPY . .
RUN composer dump-autoload --optimize --no-scripts

# Stage 2: Build Frontend Assets
FROM node:20 as frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
# Vite might need some vendor files for its plugin
COPY --from=vendor /app/vendor /app/vendor
RUN npm run build

# Stage 3: Production Image
FROM php:8.4-apache
WORKDIR /var/www/html

# Install required system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    sqlite3 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip intl bcmath \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Update Apache configuration to point to public directory and use Render's PORT
# Render sets the PORT env variable automatically. We configure Apache to listen to it.
ENV PORT=80
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -i "s/Listen 80/Listen \${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:\${PORT}>/g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy application from vendor stage
COPY --from=vendor /app /var/www/html

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build /var/www/html/public/build

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Setup permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Allow SQLite database writing if using SQLite
RUN touch /var/www/html/database/database.sqlite && \
    chown www-data:www-data /var/www/html/database/database.sqlite && \
    chmod 664 /var/www/html/database/database.sqlite && \
    chown www-data:www-data /var/www/html/database && \
    chmod 775 /var/www/html/database

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Inform Docker that the container listens on the specified port
EXPOSE ${PORT}

CMD ["apache2-foreground"]
