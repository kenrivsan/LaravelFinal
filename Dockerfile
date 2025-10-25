# Imagen base PHP (Debian)
FROM php:8.3-cli
WORKDIR /app

# 1) Paquetes del sistema + Node 20 + extensiones PHP
RUN apt-get update \
 && apt-get install -y curl git unzip libzip-dev ca-certificates gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && docker-php-ext-install zip pdo_sqlite \
 && rm -rf /var/lib/apt/lists/*

# 2) Composer
RUN curl -sS https://getcomposer.org/installer \
 | php -- --install-dir=/usr/local/bin --filename=composer

# 3) Copiar todo el proyecto
COPY . .

# 4) Instalar PHP deps (crea vendor/)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 5) Compilar assets (ahora SÍ existe vendor/)
RUN npm ci \
 && npm run build

# 6) Permisos Laravel
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs \
 && chmod -R 777 storage bootstrap/cache

# 7) Start
ENV PORT=10000
CMD ["/bin/sh","-lc","./render-start.sh"]