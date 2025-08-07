#!/bin/bash
set -e

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

php artisan storage:link || true

php artisan optimize

echo "* * * * * cd /var/www && php artisan schedule:run >> /dev/null 2>&1" | crontab -

nginx -g 'daemon off;' &

service cron start && php-fpm