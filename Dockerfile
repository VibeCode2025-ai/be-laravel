# FROM php:8.2-fpm

# RUN apt-get update && apt-get install -y \
#     zip unzip curl git libpng-dev libonig-dev libxml2-dev \
#     && docker-php-ext-install pdo_mysql mbstring gd

# WORKDIR /var/www/html
# COPY . .

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install --no-dev --optimize-autoloader

# CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip curl git \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring gd

WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create storage link
RUN php artisan storage:link

# Clear cache
RUN php artisan config:clear \
    && php artisan cache:clear \
    && php artisan optimize:clear

# Expose port
EXPOSE 10000

# Start Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
