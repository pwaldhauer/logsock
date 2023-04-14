#!/usr/bin/env sh
set -e

php artisan app:init

php-fpm -D
nginx -g 'daemon off;'
