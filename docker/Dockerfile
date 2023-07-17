# Використовуємо базовий образ PHP-FPM
FROM php:8.2-fpm

# Встановлюємо необхідні залежності PHP для роботи з PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev git zip unzip && docker-php-ext-install pdo pdo_mysql

# Встановлюємо PostgreSQL та необхідні інструменти
RUN apt-get install -y default-mysql-client

# Додамо Git
RUN apt-get update && apt-get install -y git

# Встановлюємо Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копіюємо ваш composer.json та composer.lock у контейнер
COPY composer.json composer.lock /var/www/html/

# Переходимо до робочої директорії вашого проекту
WORKDIR /var/www/html

# Встановлюємо залежності проекту через Composer
RUN composer install

RUN echo "error_log = /var/log/php/error.log" >> /usr/local/etc/php/php.ini

# Запускаємо PHP-FPM
CMD ["php-fpm"]
