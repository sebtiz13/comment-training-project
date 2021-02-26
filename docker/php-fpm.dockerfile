FROM php:8-fpm-alpine

# NOT removed dependencies
RUN apk --no-cache update && apk --no-cache add bash icu-dev git rabbitmq-c-dev

# Install build dependencies
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
  # Build and install php extensions
  && pecl install xdebug apcu \
  && docker-php-ext-configure intl && docker-php-ext-install intl \
  && docker-php-ext-install opcache pdo_mysql \
  # Remove build dependencies
  && apk del -f .build-deps

# AMQP extension need to be compiled for PHP 8
# see https://github.com/php-amqp/php-amqp/issues/386 for more informations
RUN docker-php-source extract \
    && mkdir /usr/src/php/ext/amqp \
    && curl -L https://github.com/php-amqp/php-amqp/archive/master.tar.gz | tar -xzC /usr/src/php/ext/amqp --strip-components=1 \
    && docker-php-ext-install amqp

RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Enable php extensions
RUN docker-php-ext-enable xdebug \
  && docker-php-ext-enable apcu

COPY ./docker/php /usr/local/etc/php/conf.d/

COPY . /var/www

RUN composer install

CMD ["php-fpm", "-F"]

WORKDIR /var/www/

EXPOSE 9000
