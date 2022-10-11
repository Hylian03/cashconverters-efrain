FROM php:7.4-fpm

RUN apt update && apt-get install -y

RUN apt update && apt-get install -y --no-install-recommends \
        acl \
        libcurl4-openssl-dev \
        procps \
        zip \
        unzip \
        wget \
        git \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \        
    docker-php-ext-install \    
        gd \
        zip \
        intl \
        mysqli \
        pdo \
        pdo_mysql \
        xml \
        curl \
        mbstring \
        opcache

# RUN usermod -u 1000 www-data
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt update
RUN apt install symfony-cli

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
COPY ./docker/opcache/opcache.ini $PHP_INI_DIR/conf.d/ddocker-php-ext-opcache.ini
RUN git config --global user.email "efrain.csm@gmail.com" \
    && git config --global user.name "Efrain"
WORKDIR /var/www/symfony
