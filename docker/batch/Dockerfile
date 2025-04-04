FROM public.ecr.aws/docker/library/alpine:3.16 AS base

RUN apk --no-cache add php81 php81-fpm php81-bcmath php81-ctype php81-json php81-fileinfo \
    php81-mbstring php81-openssl php81-pdo_pgsql php81-curl php81-pdo php81-tokenizer php81-xml php81-session php81-iconv \
    php81-opcache nginx curl bash runit openrc php81-simplexml php81-dom php81-xmlwriter php81-pear \
    php81-sockets php81-gd php8-iconv php81-xmlreader php81-zip php81-sodium php81-dev imagemagick imagemagick-dev patch php81-pecl-imagick \
    make gcc g++ autoconf musl-dev \
    && ln -s /usr/bin/php81 /usr/bin/php \
    && ln -s /usr/sbin/php-fpm81 /usr/sbin/php-fpm

FROM base AS build

WORKDIR /build
COPY ../.. /build
RUN apk --no-cache add php81-phar && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer && \
    composer install --no-ansi --no-interaction --optimize-autoloader --no-progress --no-dev --profile --prefer-dist

FROM base

WORKDIR /var/www/html

COPY docker/batch/php/php-fpm.conf /etc/php81/php-fpm.d/www.conf
COPY docker/batch/php/php.ini /etc/php81/conf.d/custom.ini
COPY docker/batch/boot.sh /sbin/boot.sh
COPY docker/batch/php/php.run /etc/service/php/run


RUN adduser -D -u 1000 -g 1000 -s /bin/sh www && \
    mkdir -p /var/www/html && \
    chown -R www:www /var/www/html && \
    chown -R www:www /run

COPY --from=build --chown=www /build /var/www/html/

RUN chmod +x /etc/service/php/run \
    && ls -al /var/www/html/

EXPOSE 80

# Start PHP-FPM
CMD ["sh", "/sbin/boot.sh"]
