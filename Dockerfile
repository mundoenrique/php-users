FROM php:7.0-apache

WORKDIR /var/www/html

COPY build ./
COPY src/httpd/default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update -y \
	&& apt-get install -y curl libmcrypt-dev nano \
	&& docker-php-ext-install -j$(nproc) mcrypt mysqli pdo pdo_mysql \
	&& a2enmod headers rewrite \
	&& a2ensite 000-default.conf \
	&& chown -R www-data:www-data ../ \
	&& apachectl restart
