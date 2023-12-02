FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
    && apt-get install -y \
        libcurl4-gnutls-dev \
        libpq-dev \
        supervisor \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /var/www/html

COPY ./docker/queuer/entrypoint.sh /entrypoint.sh
COPY ./docker/queuer/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
