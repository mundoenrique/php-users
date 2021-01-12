FROM php:7.4-apache

WORKDIR /var/www/html

COPY build ./
COPY src/httpd/default.conf /etc/apache2/sites-available/000-default.conf
COPY src/httpd/deflate.conf /etc/apache2/conf.d/deflate.conf

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
RUN apt-get update -y \
	&& apt-get install -y curl libmcrypt-dev nano \
	&& docker-php-ext-install mysqli \
	&& pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
	&& a2enmod headers rewrite \
	&& a2ensite 000-default.conf \
	&& chown -R www-data:www-data ../
