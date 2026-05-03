FROM php:8.2-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring xml ctype \
   fileinfo bcmath curl zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./

# grpc aur gd ko ignore karo — production mein zarurat nahi
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --ignore-platform-req=ext-grpc \
    --ignore-platform-req=ext-gd

COPY . .

# Node + npm build
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build 2>/dev/null || true
    

# Laravel setup
RUN mkdir -p storage/framework/{sessions,views,cache,testing} \
    storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

EXPOSE 8000

# FIX: Use 'sh -c' to properly evaluate the Railway $PORT variable
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
