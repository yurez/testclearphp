FROM php:8.2-fpm

RUN apt-get update && apt-get install -y libpq-dev git zip unzip && docker-php-ext-install pdo pdo_mysql

RUN apt-get install -y default-mysql-client

RUN apt-get update && apt-get install -y git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo "error_log = /var/log/php/error.log" >> /usr/local/etc/php/php.ini

CMD ["php-fpm"]
