FROM nginx

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN apt-get update \
    && apt-get install -y \
        apt-utils \
    && apt-get install -y \
        libcurl4-gnutls-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
