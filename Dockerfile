FROM php:8.2.3-fpm-alpine3.17

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions intl calendar redis

RUN apk add nginx

COPY --chown=www-data:www-data --chmod=g+r . /app

COPY .env.docker /app/.env

WORKDIR /app

RUN mkdir /app/bootstrap/cache
RUN mkdir /app/storage
RUN mkdir /app/storage/app
RUN mkdir /app/storage/framework
RUN mkdir /app/storage/framework/cache
RUN mkdir /app/storage/framework/sessions
RUN mkdir /app/storage/framework/views
RUN mkdir /app/storage/logs

RUN touch /app/storage/database.sqlite
RUN php artisan storage:link -n

RUN chown -R www-data:www-data /app/storage
RUN chown -R www-data:www-data /app/bootstrap/cache

COPY .docker/nginx.conf /etc/nginx/nginx.conf
COPY .docker/entrypoint.sh /etc/entrypoint.sh

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
