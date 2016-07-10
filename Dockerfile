FROM php:7.0.7-fpm-alpine

RUN apk upgrade -U
RUN apk --update add \
    openssl-dev \
    coreutils \
    autoconf \
    build-base \
    freetype-dev \
    jpeg-dev

# Install MongoDB
RUN pecl install -f mongodb
RUN docker-php-ext-enable mongodb

# Install the GD PHP module
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# Install application
RUN mkdir -p /var/booothy/tmp
RUN mkdir -p /var/booothy/logs
RUN mkdir -p /var/booothy/uploads/thumbs
RUN mkdir -p /var/booothy/cache/twig
RUN mkdir -p /var/booothy/cache/profiler
RUN chmod -R a+w /var/booothy

ADD . /var/www/booothy
WORKDIR /var/www/booothy

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN php composer.phar install

RUN ./bin/console app:dump
