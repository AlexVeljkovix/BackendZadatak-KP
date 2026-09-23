FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y msmtp msmtp-mta \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

WORKDIR /var/www

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/msmtprc /etc/msmtprc

RUN chmod 644 /etc/msmtprc

RUN printf "sendmail_path = /usr/bin/msmtp -t\n" \
    > /usr/local/etc/php/conf.d/mail.ini