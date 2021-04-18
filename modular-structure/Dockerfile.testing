FROM ibrunotome/php:8.0-fpm

ARG COMPOSER_FLAGS

WORKDIR /var/www

COPY . /var/www

RUN composer install $COMPOSER_FLAGS \
    && pecl install xdebug \
    && mv php.testing.ini /usr/local/etc/php/php.ini \
    && mv www.conf /usr/local/etc/php-fpm.d/www.conf \
    && chown -R 0:www-data /var/www \
    && find /var/www -type f -exec chmod 664 {} \; \
    && find /var/www -type d -exec chmod 775 {} \; \
    && chgrp -R www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

CMD ["/usr/local/sbin/php-fpm"]

EXPOSE 9000