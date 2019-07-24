FROM gregmd/homestead:latest

COPY ./build-deploy/nginx/ssl /etc/nginx/ssl

COPY ./build-deploy/nginx/domains.d /etc/nginx/domains.d

WORKDIR /var/www/app

# Add composer files
COPY composer.json composer.lock /var/www/app/

# Install dependencies only - cached before source for faster builds
RUN composer install --no-autoloader --no-scripts

# Copy current files
COPY . /var/www/app

# Dependencies are already installed, now run post-intall scripts
RUN composer install

HEALTHCHECK NONE

# Expose ports
EXPOSE 443 80

# Run command
CMD ["./build-deploy/run.sh"]
