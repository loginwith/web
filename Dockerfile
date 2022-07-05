FROM php:8.1-fpm

LABEL app=web

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
COPY --from=caddy:2 /usr/bin/caddy /usr/local/bin/caddy

RUN curl -Lso /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.5/dumb-init_1.2.5_x86_64
RUN chmod +x /usr/local/bin/dumb-init
RUN apt-get update && apt-get -y install mailcap procps vim sqlite3 && docker-php-ext-configure pcntl && docker-php-ext-install pcntl

EXPOSE 80/tcp
EXPOSE 443/tcp

WORKDIR /app
COPY ./etc /etc
COPY ./etc/php.ini /usr/local/etc/php
COPY ./init.sh ./
COPY ./*.php ./
COPY ./Caddyfile ./
COPY ./vendor/ ./vendor/
COPY ./composer* ./
COPY ./public/ ./public/
COPY ./workers/ ./workers/

ENTRYPOINT ["/usr/local/bin/dumb-init", "--"]

CMD ["/app/init.sh"]
