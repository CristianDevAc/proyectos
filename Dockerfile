# Imagen base oficial de PHP con CLI y Apache (puedes usar php-fpm si prefieres)
FROM php:8.2-apache

# Establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instalar dependencias del sistema para PostgreSQL y Laravel
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo_pgsql zip

# Habilitar mod_rewrite para Apache (Laravel lo usa)
RUN a2enmod rewrite

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el código de tu proyecto al contenedor
COPY . .

# Instalar dependencias de PHP usando Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Cambiar permisos para Apache (ajusta según necesites)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto 80 para Apache
EXPOSE 80

# Ejecutar migraciones y levantar el servidor Apache en modo foreground
CMD php artisan migrate --force && php artisan db:seed --force && apache2-foreground