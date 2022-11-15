FROM wyveo/nginx-php-fpm:php74

COPY ./docker/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY  ./docker/site.conf /etc/nginx/conf.d/site.conf
WORKDIR /var/www/html/


COPY . .
RUN chown -R $USER:$USER /var/www
RUN chmod -R 777 /var/www/html/storage
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install



