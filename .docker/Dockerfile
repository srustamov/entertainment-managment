FROM php:8.1-fpm
FROM node:lts-alpine

# PHP extensions

RUN apt-get update
RUN apt-get install git -y
RUN apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo pdo_mysql gd

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

RUN pecl install xdebug
RUN pecl install redis

# Enable PHP extensions
RUN docker-php-ext-enable xdebug redis

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

USER $user
