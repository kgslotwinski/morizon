FROM php:8.2.30-fpm-alpine

RUN apk add --no-cache \
    git \
    unzip \
    icu-dev \
    bash \
    curl \
    && docker-php-ext-install \
    intl \
    opcache

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/app

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

ARG SYMFONY_APP_PORT=8000
ENV SYMFONY_APP_PORT=${SYMFONY_APP_PORT}
EXPOSE ${SYMFONY_APP_PORT}

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]