#!/usr/bin/env bash

./build-deploy/wait-for-it.sh redis.app.local:6379 -s -t 60 -- echo "Redis is ready." && \
./build-deploy/wait-for-it.sh mysql.app.local:3306 -s -t 60 -- echo "MySQL is ready." && \
./build-deploy/customs.sh && \
vendor/bin/phpunit
