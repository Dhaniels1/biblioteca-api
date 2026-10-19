#!/bin/sh
set -eu

if [ -z "${APP_KEY:-}" ]; then
    echo "Erro: configure APP_KEY no ambiente de produção." >&2
    exit 1
fi

php artisan config:cache
php artisan route:cache
php artisan migrate --force

if [ "${SEED_DEMO_CATALOG:-false}" = "true" ]; then
    php artisan db:seed --class=CatalogoDemoSeeder --force
fi

exec apache2-foreground
