FROM phpdockerio/php:8.2-fpm

WORKDIR "/application"

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.2-mysql; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY App/ /application/App/
COPY config/ /application/config/
COPY public/ /application/public/
COPY composer.json composer.lock /application/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm8.2"]