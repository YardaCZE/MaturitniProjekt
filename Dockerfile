FROM node:16-alpine AS npm_builder

WORKDIR /app

COPY package.json ./
RUN npm install

COPY ./ ./
RUN npm run build

FROM php:8.3.8RC1-zts-alpine3.20 AS php_builder

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ ./

RUN rm -f public/hot

RUN export COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev

RUN php artisan storage:link
#RUN php artisan key:generate

FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt update && apt upgrade
RUN apt install libzip-dev zip unzip -y
RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY --from=npm_builder /app/public ./public
COPY --from=npm_builder /app/resources ./resources

COPY --from=php_builder /app /var/www/html

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN php artisan key:generate --force -n

RUN composer install
