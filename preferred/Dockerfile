FROM gcr.io/google-appengine/php72:latest

ARG ENABLE_XDEBUG
ARG COMPOSER_FLAGS='--no-scripts --no-dev --prefer-dist'
ENV COMPOSER_FLAGS=${COMPOSER_FLAGS}

RUN apt-get update -y
RUN apt-get install unzip -y
RUN apt-get install autoconf -y
RUN apt-get install build-essential -y
RUN pecl install swoole

COPY . $APP_DIR
RUN chown -R www-data.www-data $APP_DIR

RUN /build-scripts/composer.sh;

ENTRYPOINT ["/build-scripts/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

# Option to install xdebug
RUN echo "Will enable XDEBUG: $ENABLE_XDEBUG"
RUN if [ "$ENABLE_XDEBUG" = "true" ]; then pecl install xdebug; fi
RUN if [ "$ENABLE_XDEBUG" = "true" ]; then echo "zend_extension=/opt/php72/lib/x86_64-linux-gnu/extensions/no-debug-non-zts-20170718/xdebug.so" >> /opt/php72/lib/php.ini; fi

EXPOSE 8080
