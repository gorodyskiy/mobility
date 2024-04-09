FROM php:8.3-fpm 

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y git zip unzip libzip-dev
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# RUN git clone

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY ../ /var/www
WORKDIR /var/www
