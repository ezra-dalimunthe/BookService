FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo_mysql



WORKDIR /var/www/html/

COPY . .

# Copy existing application directory permissions

RUN chown -R www-data:www-data /var/www
# RUN mkdir /var/www/storage
RUN chmod -R 755 /var/www/html/storage

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install

# CMD [ "php","-S 127.0.0.1:8900","-t public" ]
