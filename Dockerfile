# Использует официальный образ PHP 8.3 с Apache в качестве базового
FROM php:8.3-apache

# Устанавливает необходимые пакеты и расширения PHP
RUN apt-get update && \
    apt-get install -y libzip-dev unzip && \
    docker-php-ext-install zip pdo_mysql && \
    a2enmod ssl rewrite && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    rm -rf /var/lib/apt/lists/*

# Копирует конфигурационные файлы PHP в контейнер
COPY ./config/ini/*.ini /usr/local/etc/php/conf.d/

# Копирует SSL сертификаты в контейнер
COPY ./config/ssl/*.pem /etc/apache2/ssl/

# Копирует конфигурацию виртуального хоста Apache в контейнер
COPY ./config/000-default.conf /etc/apache2/sites-available/

# Создает директорию для логов Apache и устанавливает права доступа
RUN mkdir -p /var/log/apache2/temp && \
    chown -R www-data:www-data /var/log/apache2/temp

# Копирует исходный код приложения в контейнер
COPY . /var/www/html

# Открывает порты 80 и 443 для HTTP и HTTPS трафика
EXPOSE 80
EXPOSE 443

# Указывает команду для запуска Apache при запуске контейнера
CMD ["apache2-foreground"]
