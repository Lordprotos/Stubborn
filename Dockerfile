FROM php:8.2-cli

# Dépendances système
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libzip-dev zlib1g-dev \
    && docker-php-ext-install intl zip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copier d'abord composer pour profiter du cache docker
COPY composer.json composer.lock* ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress || true

# Copier le reste du projet
COPY . .

# Refaire install propre après copie complète
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Variables Symfony
ENV APP_ENV=prod
ENV APP_DEBUG=0

# Render fournit $PORT
CMD sh -c "php -S 0.0.0.0:${PORT:-10000} -t public public/index.php"