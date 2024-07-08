FROM php:8.3-apache

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip \
    apache2 && \
    a2enmod ssl && \
    a2enmod rewrite && \
    docker-php-ext-install zip pdo_mysql && \
    mkdir -p /etc/apache2/ssl && \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

COPY ./config/ini/*.ini /usr/local/etc/php/conf.d/
COPY ./config/ssl/*.pem /etc/apache2/ssl/
COPY ./config/000-default.conf /etc/apache2/sites-available/
COPY ./config/ini/error.ini /usr/local/etc/php/conf.d/

RUN mkdir -p /var/log/apache2/temp && \
    chown -R www-data:www-data /var/log/apache2/temp

COPY . /var/www/html

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]
