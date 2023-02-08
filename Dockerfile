FROM silintl/php8:8.1

WORKDIR /data

COPY composer.json /data/composer.json
RUN composer install --no-scripts --no-plugins

COPY bin/ /data/bin
COPY src/ /data/src
RUN touch /data/.env

# Remove default ssl key
RUN rm /etc/ssl/private/*

ENTRYPOINT ["/data/bin/track-deployment"]
CMD ["true"]