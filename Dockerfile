# 1) Compilar assets con Vite
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
# (opcional) si tienes tailwind/postcss config, copia sus archivos:
# COPY tailwind.config.* postcss.config.* ./
COPY resources/js ./resources/js
COPY resources/css ./resources/css
RUN npm run build

# 2) PHP + Composer
FROM php:8.3-cli AS app
WORKDIR /app
# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . .
RUN composer install --no-dev --optimize-autoloader
# Permisos para Laravel
RUN mkdir -p storage/framework/{cache,sessions,views} storage/logs && chmod -R 777 storage bootstrap/cache
# Copiar assets generados
COPY --from=assets /app/public/build ./public/build

# 3) Comando de arranque (Render inyecta $PORT)
ENV PORT=10000
CMD php -S 0.0.0.0:$PORT -t public public/index.php