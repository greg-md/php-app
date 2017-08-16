#!/usr/bin/env bash

./build-deploy/prepare.sh

# Run
echo "Running..."

/usr/sbin/php-fpm

nginx -g 'daemon off;'
