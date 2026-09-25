FROM mirror.gcr.io/library/php:8.5-cli

# dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Copia o Composer
COPY --from=mirror.gcr.io/library/composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Sobe o app
CMD sh -c "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"