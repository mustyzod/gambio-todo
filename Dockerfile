FROM php:7.3-apache-stretch

<<<<<<< HEAD
=======
LABEL maintainer = ACUMENACADEMY <valade@acumen.org>

>>>>>>> b55eec51fb1606d981d559d91f4a9ef6953c7750
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
<<<<<<< HEAD
    && docker-php-ext-install zip mysqli pdo_mysql 
=======
    && docker-php-ext-install zip
>>>>>>> b55eec51fb1606d981d559d91f4a9ef6953c7750

#Install  Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

<<<<<<< HEAD
RUN a2enmod rewrite

WORKDIR /app
COPY . /app

COPY /apache.conf /etc/apache2/sites-available/000-default.conf

RUN composer install

RUN composer dump-autoload -o
=======

# Apt clean up
RUN apt-get autoclean; \
    apt-get autoremove; \
    rm -rf /var/lib/apt/lists/*



# Create Application folder
RUN mkdir -p /var/www/html && chown -f www-data:www-data /var/www/html
WORKDIR /var/www/html

#Install dependecies
COPY composer.json ./
COPY composer.lock ./
RUN composer install --prefer-dist --no-plugins --no-scripts --no-dev --no-autoloader && rm -rf /root/ .composer

# Copy source files
COPY --chown=www-data:www-data . /var/www/html/

#Set max execution time  to 2 mins because of firebase cold start
RUN echo "max_execution_time = 120" >> /usr/local/etc/php/php.ini


# Run composer dump autoload
RUN composer dump-autoload  --no-scripts --no-dev --optimize
# Copy Apache vhost
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Use port 8080 in Apache configuration files.
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf   /etc/apache2/ports.conf
EXPOSE 8080
CMD ["apache2-foreground"]
>>>>>>> b55eec51fb1606d981d559d91f4a9ef6953c7750
