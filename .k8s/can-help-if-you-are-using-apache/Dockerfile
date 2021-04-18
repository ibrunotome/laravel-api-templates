FROM composer:2.0.12 as build
WORKDIR /app 
COPY . /app 
RUN composer install --prefer-dist --classmap-authoritative --no-dev

FROM php:8.0.3-apache-buster
RUN docker-php-ext-install pdo pdo_pgsql pdo_mysql && pecl install redis

COPY --from=build /app /var/www/

RUN cp /var/www/000-default.conf /etc/apache2/sites-available/000-default.conf && \
    cp /var/www/php.ini /usr/local/etc/php/php.ini && \
    chmod +x /var/www/entrypoint.sh && \
    chmod 777 -R /var/www/storage/ && \
    echo "Listen 8080" >> /etc/apache2/ports.conf && \
    chown -R www-data:www-data /var/www/ && \
    rm -rf /var/www/html && \
    a2enmod rewrite

ENTRYPOINT ["/var/www/entrypoint.sh"]
EXPOSE 8080