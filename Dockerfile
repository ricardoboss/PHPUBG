FROM ubuntu:16.04
MAINTAINER Ricardo Boss

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update -y
RUN apt-get -y install software-properties-common
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php
RUN apt-get update -y
RUN apt-get -y --no-install-recommends install \
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
                php7.1-soap \
                php7.1-sqlite3 \
                php7.1-xml \
                php7.1-zip \
                php-xdebug \
                unzip \
                wget
RUN apt-get update
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git clone https://github.com/MCMainiac/PHPUBG.git
RUN cd PHPUBG && composer install
RUN cd PHPUBG && ./vendor/bin/phpunit