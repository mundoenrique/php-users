FROM php:7.4-apache

WORKDIR /var/www/html

COPY build ./
COPY src/httpd/default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update -y \
	&& apt-get install -y curl libmcrypt-dev nano zlib1g-dev \
	&& docker-php-ext-install mysqli \
	&& docker-php-ext-install gd \
	&& pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
	&& a2enmod headers rewrite \
	&& a2ensite 000-default.conf \
	&& chown -R www-data:www-data ../
