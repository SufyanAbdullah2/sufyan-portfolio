#!/bin/sh
set -eu

php artisan config:cache
php artisan view:cache
php artisan migrate --force

exec /usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf
