#!/usr/bin/env bash
# Perbarui website ke versi terbaru di GitHub (jalankan sebagai root di VM).
set -euo pipefail
APP_DIR="${APP_DIR:-/var/www/web-smkibu-laravel}"
cd "$APP_DIR"
artisan() { runuser -u www-data -- php "$APP_DIR/artisan" "$@"; }

artisan down --retry=30 || true
trap 'artisan up || true' EXIT

git pull --ff-only
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader --no-interaction
chown -R www-data:www-data storage bootstrap/cache
artisan migrate --force
artisan config:cache
artisan route:cache
artisan view:cache
PHPV="$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')"
systemctl reload "php${PHPV}-fpm"
echo "Selesai diperbarui: $(git log --oneline -1)"
