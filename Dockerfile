FROM php:8.2-fpm

LABEL Maintainer="Ihor Rud <Igorryd6@gmai.com>"

RUN apt-get update && apt-get install cron -y \
    nginx \
    supervisor

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libicu-dev \
    libpq-dev \
    libxpm-dev \
    libvpx-dev \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    libgmp-dev \
    git \
    curl \
    wget \
    zip \
    unzip \
    gnupg2 \
    default-mysql-client

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && apt-get install -y apt-transport-https
RUN apt-get update

RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libsodium-dev \
    libexif-dev \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    cron \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli zip intl sodium exif pcntl bcmath \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY ./.docker-local/php/php.ini /usr/local/etc/php/conf.d/php.ini
COPY ./.docker-local/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./.docker-local/webserver/default.conf /etc/nginx/sites-enabled/default
COPY ./.docker-local/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./.docker-local/cron/cronjob /etc/cron.d/cronjob
RUN chmod 0644 /etc/cron.d/cronjob
RUN crontab /etc/cron.d/cronjob
RUN touch /var/log/cron.log

COPY entrypoint.sh /scripts/entrypoint.sh
RUN chmod +x /scripts/entrypoint.sh

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN chmod 777 -R var/

EXPOSE 80

ENTRYPOINT ["/scripts/entrypoint.sh"]
