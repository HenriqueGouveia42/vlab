FROM mirror.gcr.io/library/php:8.5-cli
# dependências do sistema operacional necessárias para o PostgreSQL e Composer
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Copia o Composer (gerenciador de pacotes do PHP) para dentro do container
COPY --from=mirror.gcr.io/library/composer:latest /usr/bin/composer /usr/bin/composer
# diretorio padrao de trabalho
WORKDIR /var/www/html