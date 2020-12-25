FROM php:7.4-fpm-alpine

# Update repository
RUN set -xe \
    && apk update \
    && apk upgrade

# Fixed Intl version
RUN apk add libintl icu icu-dev \
    && docker-php-ext-install intl \
    && apk del icu-dev

# Install GD
#RUN apk add libpng-dev jpeg-dev freetype-dev libjpeg-turbo-dev \
#    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd

# Install Exif extension
#RUN docker-php-ext-install -j$(nproc) exif

# Install Bcmath extension
#RUN docker-php-ext-install -j$(nproc) bcmath

# Install Zip extension
RUN apk add libzip-dev \
    && docker-php-ext-install -j$(nproc) zip

# Install PDO
#RUN docker-php-ext-install -j$(nproc) pdo_mysql

# INstall MySQLi extension
#RUN docker-php-ext-install -j$(nproc) mysqli

# Install xdebug
ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
COPY xdebug.ini /tmp/xdebug.ini
RUN apk add --virtual .phpize-deps $PHPIZE_DEPS \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH
RUN cat /tmp/xdebug.ini >> $XDEBUGINI_PATH \
    && rm /tmp/xdebug.ini

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apk add git openssh-client \
    && set -xe \
    && curl -sS https://getcomposer.org/installer | php -d memory_limit=-1 \
    && mv composer.phar /usr/local/bin/composer

# Clear
RUN rm -rf /tmp/* /var/cache/apk/*

# Use the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/;pcre.backtrack_limit=100000/pcre.backtrack_limit=1000000000/g' "$PHP_INI_DIR/php.ini"
RUN sed -i 's/memory_limit = 128M/memory_limit = 4G/g' "$PHP_INI_DIR/php.ini"
