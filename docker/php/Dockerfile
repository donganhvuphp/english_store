FROM php:8.1-fpm-alpine

# install packages
RUN apk add -U --no-cache \
    bash \
    git \
    curl-dev \
    libxml2-dev \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    zip \
    libzip-dev \
    unzip \
    gmp-dev

# install PHP extensions
RUN docker-php-source extract
RUN cp /usr/src/php/ext/openssl/config0.m4 /usr/src/php/ext/openssl/config.m4
#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-di    r=/usr/include/ \
   # --with-png-dir=/usr/include/ --enable-gd-native- ttf
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl

# install composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN mkdir /english_store && chown 1000:1000 -R /english_store

WORKDIR /english_store
