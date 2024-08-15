#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html


 
echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force 

echo "Starting queue worker..."
php artisan queue:work --sleep=3 --tries=3 --daemon --working-dir=/var/www/html