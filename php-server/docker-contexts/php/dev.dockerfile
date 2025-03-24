FROM php:8.2-fpm-alpine
RUN apk add --no-cache mysql-client msmtp perl wget procps shadow libzip libpng libjpeg-turbo libwebp freetype icu icu-data-full

RUN apk add --no-cache --virtual build-essentials \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev libxml2-dev && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip && \
    docker-php-ext-install xml dom && \
    apk del build-essentials && rm -rf /usr/src/php*

####### PHP CONF
RUN sed -i -e "s/;daemonize = yes/daemonize = no/g" /usr/local/etc/php-fpm.conf
RUN sed -i -e "s/pm = dynamic/pm = ondemand/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i -e "s/pm.max_children = 5/pm.max_children = 250/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i -e "s/pm.start_servers = 2/pm.start_servers = 70/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i -e "s/pm.min_spare_servers = 1/pm.min_spare_servers = 70/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i -e "s/pm.max_spare_servers = 3/pm.max_spare_servers = 80/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i -e "s/;pm.max_requests = 500/pm.max_requests = 500/g" /usr/local/etc/php-fpm.d/www.conf

####### REMOVE CACHES
RUN rm -rf /tmp/* /var/cache/apk/*

####### COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

####### MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

# Cache directory to composer dependencies
WORKDIR /usr/src/cache
COPY --from=root composer.* ./

RUN composer clear-cache && \
    composer self-update && \
    composer install

####### CONFIG DIRECTORY
RUN mkdir -p /var/www/workspace
WORKDIR /var/www/workspace

#Copy all files to the container
COPY --from=root . .