FROM php:7.1-cli
WORKDIR /var/www
RUN apt-get update && apt-get install libssl-dev -y
RUN pecl install mongodb
RUN pecl install xdebug
RUN pecl install apcu
RUN docker-php-ext-enable mongodb xdebug apcu
ENTRYPOINT ["php"]
CMD ["-S",  "0.0.0.0:8080", "-t", "public", "public/index.php", ">>", "/dev/stdout"]
