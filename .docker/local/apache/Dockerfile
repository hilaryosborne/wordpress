########################
# SSL CERT BUILD
########################

FROM alpine as encrypt

WORKDIR /certs

ENV SSL_CERT "ssl-cert-snakeoil.pem"
ENV SSL_KEY "ssl-cert-snakeoil.key"

COPY .docker/build/apache/bin/generate-certs.sh /usr/local/bin/generate-certs.sh

RUN apk --update add bash openssl

RUN chmod +x /usr/local/bin/generate-certs.sh \
  && /usr/local/bin/generate-certs.sh

########################
# APACHE/PHP SERVER BUILD
########################

FROM php:7-apache AS apache

LABEL maintainer "Hilary Osborne <h.t.osborne@gmail.com>"

ENV TZ "Australia/Brisbane"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY ./.docker/local/apache/php/php.ini /usr/local/etc/php/

COPY --from=encrypt /certs /etc/ssl/certs/

RUN apt-get update && apt-get install -y \
    nano git zip \
    nfs-common \
    net-tools \
    libssl-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng12-dev \
  && docker-php-ext-install -j$(nproc) iconv mcrypt \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install -j$(nproc) mysqli pdo_mysql

RUN a2enmod rewrite \
  && a2enmod ssl

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

ARG version=development
ENV VERSION $version
