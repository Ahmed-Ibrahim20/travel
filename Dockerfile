# 1) نستخدم صورة PHP مع Composer
FROM php:8.3-fpm

# 2) تثبيت الحزم المطلوبة للـ Laravel + DB drivers
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip

# 3) نثبت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4) نحدد مجلد العمل
WORKDIR /var/www/html

# 5) ننسخ ملفات المشروع
COPY . .

# 6) نثبت الـ dependencies
RUN composer install --no-dev --optimize-autoloader

# 7) نعمل لينك للستوريج
RUN php artisan storage:link || true

# 8) نعمل Cache للـ config + route
RUN php artisan config:clear && php artisan config:cache && php artisan route:cache

# 9) الـ entrypoint → يعمل migrate + serve
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=10000
