FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev zlib1g-dev default-mysql-client \
    && docker-php-ext-install intl zip pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Vérification explicite pendant le build (important)
RUN php -m | grep -i pdo && php -m | grep -i pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

ENV APP_ENV=prod
ENV APP_DEBUG=0

COPY composer.json composer.lock* symfony.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-scripts

COPY . .

RUN printf "APP_ENV=prod\nAPP_DEBUG=0\n" > /app/.env
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public public/index.php"]