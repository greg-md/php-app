FROM fedora:25

COPY ./build-deploy /build-deploy

RUN echo "LC_ALL=en_US.UTF-8" >> /etc/environment
RUN echo "LC_CTYPE=en_US.UTF-8" >> /etc/environment

RUN dnf install wget -y

RUN wget http://rpms.remirepo.net/fedora/remi-release-25.rpm \
    && dnf install remi-release-25.rpm -y \
    && dnf install dnf-plugins-core -y \
    && dnf config-manager --set-enabled remi-php71

RUN dnf --setopt=deltarpm=false update -y

RUN dnf install mc gcc gcc-c++ libaio kernel-devel pcre-devel openssl-devel telnet tar bzip2 htop unzip make sudo -y

RUN /build-deploy/install/nginx.sh

RUN /build-deploy/install/php.sh

COPY . /var/www/app

WORKDIR /var/www/app

EXPOSE 443 80

CMD ["./build-deploy/run.sh"]
