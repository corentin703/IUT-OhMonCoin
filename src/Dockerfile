FROM php:7-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
	
RUN \
	apt-get update \
	&& apt-get install -y git
	
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

WORKDIR /var/www/html/

RUN \
	a2enmod rewrite \
	&& chmod -R 777 /var/www/html/ \
	&& /usr/local/bin/composer install --no-dev 
