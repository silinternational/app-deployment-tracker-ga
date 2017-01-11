FROM silintl/php7:latest

WORKDIR /data

COPY composer.json /data/composer.json
RUN composer install --no-scripts --no-plugins

COPY track.php /data
RUN touch /data/.env

CMD ["php", "/data/track.php"]