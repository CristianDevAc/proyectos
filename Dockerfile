FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    git \
    vim \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Instalar Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear carpeta de la app
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Asignar permisos correctos
RUN chown -R www-data:www-data /var/www

# Puerto expuesto
EXPOSE 8000

# Agregar PHP extension check (opcional)
RUN php -m | grep -i pgsql && php -m | grep -i pdo_pgsql

# Ejecutar migraciones y levantar servidor Laravel
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000