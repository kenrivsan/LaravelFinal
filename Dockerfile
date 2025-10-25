# Usa PHP con Composer y extensiones necesarias
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Copiar los archivos de la aplicación al contenedor
WORKDIR /var/www/html
COPY . .

# Instalar Composer y dependencias de Laravel
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader


# Crear base de datos vacía si no existe
RUN mkdir -p database && touch database/database.sqlite

# Establecer permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Establecer variables de entorno
ENV PORT=10000
EXPOSE 10000

# === 🚀 Comando de inicio ===
# Ejecuta migraciones y luego arranca el servidor
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT