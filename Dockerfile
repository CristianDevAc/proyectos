FROM php:8.2-fpm

# Actualiza paquetes, instala dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    zip \
    libzip-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo_pgsql zip pdo

# Copia el proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala las dependencias de PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajusta permisos (importante para storage y cache)
RUN chown -R www-data:www-data storage bootstrap/cache

# Expone puerto 9000 para PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]