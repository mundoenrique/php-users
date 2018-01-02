FROM php:7.0-apache
MAINTAINER NovoPayment Inc.

WORKDIR /var/www/html

COPY build ./
COPY src/httpd/default.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update -y \
	&& apt-get install -y curl libmcrypt-dev libssh2-1-dev \
	&& docker-php-ext-install -j$(nproc) mcrypt \
	&& pecl install ssh2-1.0 \
	&& docker-php-ext-enable ssh2 \
	&& a2enmod headers rewrite \
	&& a2ensite 000-default.conf \
	&& mkdir /var/www/sessions \
	&& chmod 0700 /var/www/sessions \
	&& chown -R www-data:www-data /var/www/** \
	&& usermod -u 1000 www-data \
	&& apachectl restart

VOLUME ["/var/www/html"]
