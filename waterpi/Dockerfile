FROM sergeytykhonov/rpi-php:7.1

#RUN apk add --no-cache --virtual .persistent-deps git

COPY . /usr/src/app
WORKDIR /usr/src/app

CMD ["php", "./waterpi.php"]
