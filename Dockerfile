FROM composer as composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install

FROM php:8.3-alpine as dev
COPY --from=composer /app/ /app/
COPY . /app
COPY .env.example .env
WORKDIR /app
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
