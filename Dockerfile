# Imagen base optimizada que ya incluye PHP, Composer y extensiones comunes
FROM laravelsail/php82-composer:latest

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos del proyecto al contenedor
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Da permisos a los archivos
RUN chown -R www-data:www-data /var/www

# Expone el puerto donde Laravel servirá la app
EXPOSE 8000

# Ejecuta migraciones, seeders y levanta Laravel
CMD php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=8000