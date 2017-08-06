FROM ubuntu:16.04
MAINTAINER Ricardo Boss

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update -y > /dev/null ; \
	apt-get install -y software-properties-common > /dev/null ; \
	LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php > /dev/null ; \
	apt-get update -y > /dev/null ; \
	apt-get install --no-install-recommends -y \
                ca-certificates \
                curl \
                git \
                php7.1 \
                php7.1-cli \
                php7.1-curl \
                php7.1-fpm \
                php7.1-intl \
                php7.1-ldap \
                php7.1-mbstring \
                php7.1-xml \
                php7.1-zip \
                php-xdebug ; \
	apt-get update -y > /dev/null ; \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git clone https://github.com/MCMainiac/PHPUBG.git --branch master ; \
	cd PHPUBG ; \
	composer install ; \
	./vendor/bin/phpunit