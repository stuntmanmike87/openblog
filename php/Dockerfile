FROM php:8.4-apache-bullseye
# FROM php:8.4-apache
# FROM php:8.4-alpine
# FROM php:8.4-fpm-alpine

RUN apt-get update \
    # && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && apt-get install -y build-essential curl zlib1g-dev g++ libicu-dev zip libzip-dev libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install  gd \
    && docker-php-ext-install exif

RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# RUN git config --global user.email "mich.perigaud@gmail.com"
# RUN git config --global user.name "stuntmanmike87"
