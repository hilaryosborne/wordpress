FROM php:7-apache

LABEL maintainer "Hilary Osborne <h.t.osborne@gmail.com>"

# Configure system
ENV TZ "Australia/Brisbane"
RUN echo $TZ > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

COPY ./.docker/stage/apache/php/php.ini /usr/stage/etc/php/
COPY ./.docker/stage/apache/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./.docker/stage/apache/sites-available/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf
COPY ./.docker/stage/apache/certs/ssl-cert-snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem
COPY ./.docker/stage/apache/certs/ssl-cert-snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key

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

ENV ACF_PRO_KEY <ACF_PRO_KEY>

# Setup app
WORKDIR /var/www/html

COPY . /var/www/html

RUN mkdir /var/www/html/public

RUN composer install --no-ansi --no-autoloader --no-dev --no-interaction \
  && composer dump-autoload --optimize

RUN rm -rf /var/www/html/public/wp-content/plugins \
  && rm -rf /var/www/html/public/wp-content/cache \
  && rm -rf /var/www/html/public/wp-content/uploads

RUN yarn install \
  && yarn build:dist \
  && rm -rf /var/www/html/node_modules \
  && rm -rf ~/.npm

RUN mv -f /var/www/html/plugins /var/www/html/public/wp-content/mu-plugins \
  && mv -f /var/www/html/theme/ /var/www/html/public/wp-content/themes/boilerplate

RUN mv -f /var/www/html/bootstrap /var/www/html/public/wp-content/mu-plugins/bootstrap \
  && mv -f /var/www/html/vendor /var/www/html/public/wp-content/mu-plugins/bootstrap/vendor \
  && mv -f /var/www/html/app /var/www/html/public/wp-content/mu-plugins/bootstrap/app

# REMOVE IF MOUNTING EXTERNAL RESOURCES
RUN mv -f /var/www/html/storage/plugins /var/www/html/public/wp-content/plugins \
  && mv -f /var/www/html/storage/cache /var/www/html/public/wp-content/cache \
  && mv -f /var/www/html/storage/uploads /var/www/html/public/wp-content/uploads
# END IF REMOVE IF EXTERNAL RESOURCES

COPY ./.env /var/www/html/public/.env
COPY ./config.php /var/www/html/public/wp-config.php
COPY ./.docker/stage/apache/public/.htaccess /var/www/html/public/.htaccess

RUN chgrp -R www-data /var/www/html \
  && chmod -R ug+rwx /var/www/html

# Versioning
ARG version=development
ENV VERSION $version
