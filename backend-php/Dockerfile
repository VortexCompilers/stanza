FROM php:8.2-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev unzip git \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Serve a pasta public/ como document root (padrão Slim/front-controller).
RUN sed -ri -e 's!DocumentRoot /var/www/html!DocumentRoot /var/www/html/public!g' \
        /etc/apache2/sites-available/*.conf \
    && { \
        echo '<Directory /var/www/html/public>'; \
        echo '    AllowOverride All'; \
        echo '    Require all granted'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/stanza.conf \
    && a2enconf stanza

# Sem isso, $_ENV fica vazio dentro do PHP mesmo com as variaveis de
# ambiente do docker-compose definidas (variables_order padrao nao inclui "E").
RUN echo "variables_order = EGPCS" > /usr/local/etc/php/conf.d/variables-order.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

EXPOSE 80
