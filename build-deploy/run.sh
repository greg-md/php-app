#!/usr/bin/env bash

# Packages
#echo "Install packages."
#composer update

# Migrations
#echo "Run migrations."
#vendor/bin/phinx migrate

# Run
echo "Running."

/usr/sbin/php-fpm

nginx -g 'daemon off;'
