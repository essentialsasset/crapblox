FROM php:8.2.2-fpm

RUN apt-get update && apt-get install -y apt-transport-https
RUN apt install -y libxml2
RUN apt install -y libxml2-dev
RUN apt install -y libicu-dev
RUN apt install -y libzip-dev
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN pecl install apcu
RUN docker-php-ext-enable apcu
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif
RUN docker-php-ext-install xml
RUN docker-php-ext-enable xml
RUN docker-php-ext-install soap
RUN docker-php-ext-enable soap
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets

# Copy php.ini-production
COPY prod.ini "$PHP_INI_DIR/php.ini-production"
COPY pool.ini "/usr/local/etc/php-fpm.conf"
COPY www.ini "/usr/local/etc/php-fpm.d/www.conf"
COPY www.ini "/usr/local/etc/php-fpm.d/www.default.conf"
# Then move into php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

#RUN sed -E -i -e 's/pm = dynamic/pm = dynamic/' /usr/local/etc/php \
# && sed -E -i -e 's/pm.max_children = 201/pm.max_children = 201/' /usr/local/etc/php \
# && sed -E -i -e 's/pm.start_servers = 50/pm.start_servers = 50/' /usr/local/etc/php \
# && sed -E -i -e 's/pm.min_spare_servers = 50/pm.min_spare_servers = 50/' /usr/local/etc/php \
# && sed -E -i -e 's/pm.max_spare_servers = 150/pm.max_spare_servers = 150/' /usr/local/etc/php