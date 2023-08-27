FROM php:8.2-fpm

WORKDIR /app

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    # build-base \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpng-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    locales \
    libpq-dev \
    libzip-dev \
    curl \
    libonig-dev 
    # postgresql-contrib

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl pdo pdo_pgsql bcmath sockets
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Copy config
# COPY ./config/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN addgroup --gid 1000 --system www && \
    adduser --uid 1000 --system www --ingroup www

USER www

COPY --chown=www:www . /app
# COPY ./docker/supervisord.conf /etc/supervisord.conf

# CMD ["/usr/bin/supervisord", "-n"]

EXPOSE 9000

