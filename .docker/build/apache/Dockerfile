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
# PHP COMPOSER BUILD
########################

FROM composer AS backend

WORKDIR /app

COPY . /app

RUN composer install --prefer-dist -vvv --profile
RUN composer dump-autoload --optimize --classmap-authoritative

########################
# NODEJS BUILD
########################

FROM node AS frontend

WORKDIR /app

COPY . /app

RUN npm install \
  && npm run build:dist

########################
# APACHE/PHP SERVER BUILD
########################

FROM php:7-apache as apache

LABEL maintainer "Hilary Osborne <h.t.osborne@gmail.com>"

ENV TZ "Australia/Brisbane"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY .docker/build/apache/php/php.ini /usr/etc/php/

COPY .docker/build/apache/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN ln -sf /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .docker/build/apache/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
RUN ln -sf /etc/apache2/sites-available/default-ssl.conf /etc/apache2/sites-enabled/default-ssl.conf

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

WORKDIR /var/www/html

COPY --from=backend /app /var/www/html

COPY --from=frontend /app/theme /var/www/html/theme

RUN rm -rf /var/www/html/public/wp-content/plugins \
  && rm -rf /var/www/html/public/wp-content/cache \
  && rm -rf /var/www/html/public/wp-content/uploads

RUN rm -rf /var/www/html/node_modules \
  && rm -rf ~/.npm

RUN mv -f /var/www/html/plugins /var/www/html/public/wp-content/mu-plugins \
  && mv -f /var/www/html/theme/ /var/www/html/public/wp-content/themes/boilerplate

RUN mv -f /var/www/html/bootstrap /var/www/html/public/wp-content/mu-plugins \
  && mv -f /var/www/html/vendor /var/www/html/public/wp-content/mu-plugins/bootstrap \
  && mv -f /var/www/html/app /var/www/html/public/wp-content/mu-plugins/bootstrap

COPY ./.env /var/www/html/public/.env
COPY ./config.php /var/www/html/public/wp-config.php
COPY .docker/build/apache/public/.htaccess /var/www/html/public/.htaccess

RUN a2enmod rewrite \
  && a2enmod ssl

RUN chgrp -R www-data /var/www/html \
  && chmod -R ug+rwx /var/www/html

ARG version=development
ENV VERSION $version
