FROM php:8.2-apache-bullseye
RUN apt-get update -y && apt-get install -y git zlib1g-dev libzip-dev zip unzip libpng-dev && rm -rf /var/lib/apt
RUN docker-php-ext-configure zip \
      && docker-php-ext-install zip \
      && docker-php-ext-configure gd \
      && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN composer require phpoffice/phpspreadsheet
COPY ./html /var/www/html
EXPOSE 80
CMD ["apache2-foreground"]