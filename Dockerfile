FROM php:8.2-cli

# Cài thư viện hệ thống
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    curl \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy source
COPY . .

# Cài package Laravel
RUN composer install --no-dev --optimize-autoloader

# Mở port Render
EXPOSE 10000

# Start Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000
