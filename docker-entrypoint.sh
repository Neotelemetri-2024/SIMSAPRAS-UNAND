#!/bin/bash
set -e

# Start Nginx in background
nginx -g 'daemon off;' &

# Start PHP-FPM
php-fpm