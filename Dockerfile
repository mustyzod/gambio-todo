FROM php:7.3-apache-stretch

RUN export DEBIAN_FRONTEND=noninteractive && \
    apt-get update -qq && \
    apt-get install -y --no-install-recommends apt-utils && \
    apt-get install -y --no-install-recommends \
    git\
    curl \
    lsof \
    net-tools \
    libzip-dev \
    lsb-release \
    zlib1g-dev \
    unattended-upgrades && \
    unattended-upgrade -d && \
    rm -rf /var/lib/apt/lists/*


#install some base extensions
RUN apt-get install -y \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip mysqli pdo_mysql 

#Install  Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

WORKDIR /app
COPY . /app

COPY /apache.conf /etc/apache2/sites-available/000-default.conf

RUN composer install

RUN composer dump-autoload -o
