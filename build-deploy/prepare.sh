#!/usr/bin/env bash

# Install PHP Packages
echo "Install packages..."

composer install

# Check if ready
./build-deploy/wait-for-it.sh redis.app.local:6379 -s -t 60 -- echo "Redis is ready." && \
./build-deploy/wait-for-it.sh mysql.app.local:3306 -s -t 60 -- echo "MySQL is ready." && \

# Run custom commands
for file in build-deploy/run/*; do
    [ -f "$file" ] && [ -x "$file" ] && "$file"
done
