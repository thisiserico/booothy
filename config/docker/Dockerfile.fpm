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
