FROM php:7-apache

LABEL maintainer "Hilary Osborne <h.t.osborne@gmail.com>"

# Configure system
ENV TZ "Australia/Brisbane"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY ./.docker/local/apache/certs/ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
COPY ./.docker/local/apache/certs/ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key

COPY ./.docker/local/apache/php/php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y \
        net-tools \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

RUN a2enmod rewrite \
  && a2enmod ssl \
  && a2ensite default-ssl \
  && service apache2 restart

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# Versioning
ARG version=development
ENV VERSION $version
