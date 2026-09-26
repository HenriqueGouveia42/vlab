FROM php:8.5.0-cli-alpine

RUN apk add --no-cache curl zip unzip git libpq-dev postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

EXPOSE 8000