FROM php:7.1-apache

RUN docker-php-ext-install pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN curl https://phar.phpunit.de/phpunit-6.5.phar --output phpunit
RUN chmod +x phpunit && \
    mv phpunit /usr/local/bin/phpunit
