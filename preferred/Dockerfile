FROM gcr.io/google-appengine/php72:latest

ARG COMPOSER_FLAGS='--no-dev --prefer-dist --ignore-platform-reqs --optimize-autoloader'
ENV COMPOSER_FLAGS=${COMPOSER_FLAGS}
ENV SWOOLE_VERSION=4.3.4

COPY . $APP_DIR

RUN apt-get update -y \
&& apt-get install -y \
unzip \
autoconf \
build-essential \
libmpdec-dev \
libpq-dev \
&& pecl install decimal \
&& curl -o /tmp/swoole.tar.gz https://github.com/swoole/swoole-src/archive/v$SWOOLE_VERSION.tar.gz -L \
&& tar zxvf /tmp/swoole.tar.gz \
&& cd swoole-src* \
&& phpize \
&& ./configure \
--enable-coroutine \
--enable-async-redis \
--enable-coroutine-postgresql \
&& make \
&& make install \
&& chown -R www-data.www-data $APP_DIR \
&& /build-scripts/composer.sh;

ENTRYPOINT ["/build-scripts/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]

EXPOSE 8080
