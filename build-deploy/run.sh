#!/usr/bin/env bash

# Packages
echo "Install packages..."

composer update

for file in build-deploy/run/*; do
    [ -f "$file" ] && [ -x "$file" ] && "$file"
done

# Run
echo "Running..."

/usr/sbin/php-fpm

nginx -g 'daemon off;'
