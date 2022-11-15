FROM php:7.4-fpm-alpine

# library needed to connect to database
RUN docker-php-ext-install pdo_mysql

# library needed to connect to redis
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        && pecl install redis \
        && docker-php-ext-enable redis.so

WORKDIR /var/www/html/

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer



