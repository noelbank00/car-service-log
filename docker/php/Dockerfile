FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && \
apt-get install -y --force-yes --no-install-recommends \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libzip-dev \
    zlib1g-dev \
    openssh-client \
    libmagickwand-dev \
    unzip \
    git \
    python3-pip python3-setuptools \
    nano \
    vim

# Install intl extention
RUN docker-php-ext-install intl

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP bz2 extension
RUN docker-php-ext-install bz2

# Install the PHP opcache extension
RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache

# Install the PHP redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* && rm -R /var/www/*

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer
# Source the bash
RUN . ~/.bashrc

COPY ./php.ini /usr/local/etc/php/conf.d/99-docker.ini

RUN usermod -s /bin/bash www-data

ENTRYPOINT ["/var/www/docker/php/docker-entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]
