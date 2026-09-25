FROM mirror.gcr.io/library/php:8.5-cli

# dependências do sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# copia o Composer
COPY --from=mirror.gcr.io/library/composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copia os ficheiros e instala as dependências
COPY . .
RUN composer install --no-interaction --optimize-autoloader

# Sobe o app (agora com --seed)
CMD sh -c "php artisan migrate --seed --force && php artisan serve --host=0.0.0.0 --port=8000"