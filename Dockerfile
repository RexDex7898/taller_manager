FROM php:8.3-cli-alpine

# Instalar certificados SSL (ca-certificates) y extensiones de PHP necesarias
RUN apk add --no-cache \
    ca-certificates \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    icu-dev \
    && docker-php-ext-install pdo pdo_mysql zip bcmath intl opcache

# Copiar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar todo el código del proyecto
COPY . /app

# Instalar dependencias de producción
RUN composer install --no-dev --optimize-autoloader

# Puerto de Render
EXPOSE 8080

# Comando para ejecutar migraciones y levantar el servidor
CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}