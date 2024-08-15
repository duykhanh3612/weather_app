#!/usr/bin/env bash

# Chạy các lệnh khởi tạo
echo "Running deploy script"
bash /path/to/00-laravel-deploy.sh

# Khởi động PHP-FPM
php-fpm

# Khởi động queue worker
php artisan queue:work --sleep=3 --tries=3 --daemon --working-dir=/var/www/html &
