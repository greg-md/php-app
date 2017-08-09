FROM fedora:26

RUN echo "LC_ALL=en_US.UTF-8" >> /etc/environment
RUN echo "LC_CTYPE=en_US.UTF-8" >> /etc/environment

#RUN dnf install wget -y

RUN dnf --setopt=deltarpm=false update -y

RUN rpm -Uvh http://rpms.famillecollet.com/fedora/remi-release-26.rpm

RUN dnf install dnf-plugins-core -y

RUN dnf config-manager --set-enabled remi

RUN dnf install mc gcc gcc-c++ libaio kernel-devel pcre-devel openssl openssl-devel telnet tar bzip2 htop unzip make sudo wget git -y

# Copy install files
COPY ./build-deploy/install /install

# Install Nginx
RUN /install/nginx.sh

COPY ./build-deploy/nginx/ssl /etc/nginx/ssl

COPY ./build-deploy/nginx/domains.d /etc/nginx/domains.d

# Install PHP
RUN /install/php.sh

# Copy current files
COPY . /var/www/app

WORKDIR /var/www/app

# Expose ports
EXPOSE 443 80

# Run command
CMD ["./build-deploy/run.sh"]
