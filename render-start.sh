#!/usr/bin/env bash
set -e
DB_PATH="${DB_DATABASE:-/var/tmp/database.sqlite}"
PORT="${PORT:-8080}"
mkdir -p "$(dirname "$DB_PATH")"
[ -f "$DB_PATH" ] || touch "$DB_PATH"
php artisan migrate --force --seed
php -S 0.0.0.0:$PORT -t public public/index.php
