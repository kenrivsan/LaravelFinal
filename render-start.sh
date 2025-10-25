#!/usr/bin/env bash
set -euo pipefail

# Si tu servicio NO tiene Root Directory = web-2v5, quita este cd.
# (En este Dockerfile ya copiamos web-2v5 a /app, así que NO es necesario cd.)
# cd web-2v5

# .env si no existe
php -r "file_exists('.env') || copy('.env.example', '.env');"

# APP_KEY y caches
php artisan key:generate --force || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Soporte SQLite opcional
if [ "${DB_CONNECTION:-}" = "sqlite" ]; then
  DB_PATH="${DB_DATABASE:-/var/tmp/database.sqlite}"
  mkdir -p "$(dirname "$DB_PATH")"
  [ -f "$DB_PATH" ] || touch "$DB_PATH"
fi

# Migraciones/seed (no rompas el arranque si fallan por primera vez)
php artisan migrate --force || true
php artisan db:seed --force || true

# Servidor PHP embebido con document root en public
php -S 0.0.0.0:${PORT:-8080} -t public public/index.php