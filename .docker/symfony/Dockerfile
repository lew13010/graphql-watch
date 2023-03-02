FROM php:8.2-fpm-bullseye
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    nano \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    zip xsl gd intl opcache exif mbstring

# Install Postgres PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql


# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# because PhpCsFixer does not supports PHP 8.2 at the moment
ENV PHP_CS_FIXER_IGNORE_ENV=1

# Git configuration
RUN git config --global --add safe.directory /var/www/symfony
RUN git config --global user.email "${GIT_USER_EMAIL}"
RUN git config --global user.name "${GIT_USER_NAME}"

WORKDIR /var/www/symfony