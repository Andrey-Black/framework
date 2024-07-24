FROM php:8.3-apache

RUN apt-get update && \
    apt-get install -y libzip-dev unzip && \
    docker-php-ext-install zip pdo_mysql && \
    a2enmod ssl rewrite && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    rm -rf /var/lib/apt/lists/*

COPY ./config/ini/*.ini /usr/local/etc/php/conf.d/
COPY ./config/ssl/*.pem /etc/apache2/ssl/
COPY ./config/000-default.conf /etc/apache2/sites-available/

RUN mkdir -p /var/log/apache2/temp && \
    chown -R www-data:www-data /var/log/apache2/temp

COPY . /var/www/html

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]
