FROM php:7-apache

LABEL maintainer "Hilary Osborne <h.t.osborne@gmail.com>"

# Configure system
ENV TZ "Australia/Brisbane"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY ./.docker/local/apache/php/php.ini /usr/local/etc/php/
COPY ./.docker/local/apache/certs/ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
COPY ./.docker/local/apache/certs/ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key

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
  && a2enmod ssl \
  && a2ensite default-ssl \
  && service apache2 restart

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN set -ex \
  && curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
  && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
  && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
  && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer --snapshot && rm -rf /tmp/composer-setup.php \
  && rm -f /tmp/composer-setup.*

# Install node
ENV NODE_VERSION 8.1.4
RUN set -ex \
  && curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz" \
  && tar -xJf "node-v$NODE_VERSION-linux-x64.tar.xz" -C /usr/local --strip-components=1 \
  && ln -s /usr/local/bin/node /usr/local/bin/nodejs \
  && ln -s /usr/bin/nodejs /usr/bin/node \
  && rm node-v$NODE_VERSION-linux-x64.tar.xz

ENV YARN_VERSION 0.27.5
RUN set -ex \
  && curl -fSLO --compressed "https://yarnpkg.com/downloads/$YARN_VERSION/yarn-v$YARN_VERSION.tar.gz" \
  && mkdir -p /opt/yarn \
  && tar -xzf yarn-v$YARN_VERSION.tar.gz -C /opt/yarn --strip-components=1 \
  && ln -s /opt/yarn/bin/yarn /usr/local/bin/yarn \
  && rm yarn-v$YARN_VERSION.tar.gz

ENV ACF_PRO_KEY b3JkZXJfaWQ9NDY1MjN8dHlwZT1wZXJzb25hbHxkYXRlPTIwMTQtMTItMTggMDA6NDU6MTg=

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# Versioning
ARG version=development
ENV VERSION $version
