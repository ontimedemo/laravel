FROM php:7.1-fpm

ARG user

RUN apt-get update
RUN apt-get -y install libpng-dev
RUN docker-php-ext-install -j$(nproc) pdo pdo_mysql mbstring
RUN apt-get install -y libpng12-dev libjpeg62-turbo-dev libfreetype6-dev && docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-png-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && docker-php-ext-install gd
RUN pecl install apcu && docker-php-ext-enable apcu
ADD https://pecl.php.net/get/apcu_bc-1.0.3.tgz /tmp/apcu_bc.tar.gz
RUN mkdir -p /usr/src/php/ext/apcu-bc && tar xf /tmp/apcu_bc.tar.gz -C /usr/src/php/ext/apcu-bc --strip-components=1
RUN docker-php-ext-configure apcu-bc && docker-php-ext-install apcu-bc

RUN rm -rd /usr/src/php/ext/apcu-bc && rm /tmp/apcu_bc.tar.gz

#Load APCU.ini before APC.ini
RUN rm /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini
RUN echo extension=apcu.so > /usr/local/etc/php/conf.d/20-php-ext-apcu.ini

RUN rm /usr/local/etc/php/conf.d/docker-php-ext-apc.ini
RUN echo extension=apc.so > /usr/local/etc/php/conf.d/21-php-ext-apc.ini

RUN docker-php-ext-install opcache && docker-php-ext-enable opcache

RUN mkdir -p /var/www/html/var
#RUN usermod -u 1000 www-data
RUN useradd $user

RUN chown -R $user:www-data /var/www/html/var/
RUN chmod -R 777 /var/www/html/var/
RUN rm -rf /usr/local/etc/php/conf.d/opcache-recommended.ini

VOLUME "/var/www/html"
