FROM php:8.4-fpm-alpine3.21

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions gd pdo pdo_mysql mysqli zip bcmath sockets opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --disable-tls

RUN apk add --no-cache nodejs npm git bash

WORKDIR /var/www

COPY . .

# New step: Force update symfony/flex to a compatible version (v2.0+)
# NOTE: Use 'composer update --no-scripts' to prevent other scripts from running during this update.
#RUN composer update symfony/flex --no-scripts --no-interaction
RUN composer config --no-interaction allow-plugins.symfony/flex true
#RUN composer config --no-interaction allow-plugins.symfony/flex true

RUN composer update

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8081", "-t", "/var/www/public"]