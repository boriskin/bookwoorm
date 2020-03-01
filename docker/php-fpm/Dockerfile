FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    zip \
    wget\
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring xml intl \
    && pecl install apcu \
    && pecl install xdebug \
    && pecl clear-cache

# Enable PHP extensions
RUN docker-php-ext-enable intl apcu opcache xdebug
# Xdebug config
RUN echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_port=9090 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.idekey=PHPSTORM >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.remote_host=host.docker.internal >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo xdebug.cli_color=1  >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
#    && echo xdebug.file_link_format=phpstorm://open?%f:%l >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ADD ./php.ini /usr/local/etc/php/php.ini

# Get latest Composer
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$(wget -q -O - https://composer.github.io/installer.sig)') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Get symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony
