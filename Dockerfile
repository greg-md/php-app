FROM gregmd/homestead

COPY ./build-deploy/nginx/ssl /etc/nginx/ssl

COPY ./build-deploy/nginx/domains.d /etc/nginx/domains.d

# Copy current files
COPY . /var/www/app

WORKDIR /var/www/app

# Expose ports
EXPOSE 443 80

# Run command
CMD ["./build-deploy/run.sh"]
