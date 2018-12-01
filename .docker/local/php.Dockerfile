FROM php:7.1-fpm-alpine
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
COPY environment.ini /usr/local/etc/php/conf.d/environment.ini
COPY xdebug.ini /tmp/xdebug.ini

RUN set -xe \
    # Update repository
    && apk update \
    && apk upgrade \

    # Git (need for composer)
    && apk add --no-cache git openssh-client \

     # Fixed Intl version
    && apk add --no-cache libintl icu icu-dev \
    && docker-php-ext-install intl pdo pdo_mysql \
    && apk del icu-dev \

    # Install xdebug
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH \
    && cat /tmp/xdebug.ini >> $XDEBUGINI_PATH \
    && rm /tmp/xdebug.ini \

    # Clear
    && rm -rf /tmp/* /var/cache/apk/*

RUN set -xe \
    && curl -sS https://getcomposer.org/installer | php -d memory_limit=-1 \
    && mv composer.phar /usr/local/bin/composer
