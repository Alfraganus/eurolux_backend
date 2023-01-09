ARG PHP_VERSION

FROM php:${PHP_VERSION}
RUN apt-get update && \
        apt-get install -y \
            make g++ gcc zlib1g zlib1g-dev curl libcurl4-openssl-dev libcurl4 libevent-dev libidn11-dev \
            libssl-dev git

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --version=2.0.7 \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

RUN docker-php-ext-install pdo_mysql

RUN pecl install -of xdebug && docker-php-ext-enable xdebug

WORKDIR /var/www/html