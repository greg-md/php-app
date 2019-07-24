#!/usr/bin/env bash

echo "Run PHP-FPM."
/usr/sbin/php-fpm

echo "Run NGINX."
nginx -g 'daemon off;'
