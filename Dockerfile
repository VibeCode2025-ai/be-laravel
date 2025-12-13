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

RUN apt-get update && apt-get install -y \
    zip unzip curl git \
    libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring gd

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

# Quyền thư mục
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Chỉ tạo storage link (KHÔNG ĐỤNG DB)
RUN php artisan storage:link

EXPOSE 10000

# 👉 CHỈ CHẠY NHỮNG THỨ CẦN DB KHI CONTAINER START
CMD php artisan migrate --force || true && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php artisan optimize:clear && \
    php artisan serve --host=0.0.0.0 --port=10000
