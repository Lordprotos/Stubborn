FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev zlib1g-dev \
    && docker-php-ext-install intl zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Important pour Symfony pendant le build
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Cache Docker pour dépendances
COPY composer.json composer.lock* symfony.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

# Copier le projet
COPY . .

# (Optionnel) dump-autoload après copie
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

CMD sh -c "php -S 0.0.0.0:${PORT:-10000} -t public public/index.php"