FROM php:8.3-apache
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libzip-dev libicu-dev libonig-dev libxml2-dev libsqlite3-dev \
    && docker-php-ext-install pdo_mysql pdo_sqlite zip intl mbstring bcmath xml \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/html
COPY . .
RUN mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache database \
    && touch database/database.sqlite \
    && composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader --no-scripts \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R ug+rwX storage bootstrap/cache database
COPY docker/entrypoint.sh /usr/local/bin/esocial-entrypoint
RUN chmod +x /usr/local/bin/esocial-entrypoint
EXPOSE 80
ENTRYPOINT ["esocial-entrypoint"]
CMD ["apache2-foreground"]
