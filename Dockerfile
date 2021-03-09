FROM php:7.3-apache

RUN apt-get update
RUN docker-php-ext-install mysqli && docker-php-ext-install pdo_mysql

RUN ["/bin/bash", "-c", "a2enmod rewrite"]
RUN ["/bin/bash", "-c", "service apache2 restart"]

EXPOSE 80