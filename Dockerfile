FROM php:7.4-apache-buster

COPY ./ /opt/sudoku

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN cd /opt/sudoku && composer install \
    && rm -rf /var/www/html \
    && ln -sf /opt/sudoku/web /var/www/html

WORKDIR /opt/sudoku
