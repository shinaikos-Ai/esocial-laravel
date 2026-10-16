#!/bin/sh
set -eu
mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache database
[ -f database/database.sqlite ] || touch database/database.sqlite
if [ ! -f .env ]; then cp .env.example .env; fi
# Keep a persistent application key across container recreation.
if [ ! -s storage/.docker_app_key ]; then
  if grep -q '^APP_KEY=base64:' .env; then
    sed -n 's/^APP_KEY=//p' .env | head -1 > storage/.docker_app_key
  else
    php -r 'echo "base64:".base64_encode(random_bytes(32));' > storage/.docker_app_key
  fi
fi
export APP_KEY="$(cat storage/.docker_app_key)"
chown -R www-data:www-data storage bootstrap/cache database
php artisan package:discover --ansi
php artisan migrate --force
exec "$@"
