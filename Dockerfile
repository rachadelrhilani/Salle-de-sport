FROM php:8.3-apache

RUN docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli


RUN a2enmod rewrite


COPY . /var/www/html


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
