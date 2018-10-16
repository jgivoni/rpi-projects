**WaterPi**

*Install dependencies*
```
$ docker run --rm -it \
    --volume $PWD:/app \
    --user $(id -u):$(id -g) \
    composer install
```

*Build app*
```
$ docker build -t waterpi .
```

*Run app*
```
$ docker run -it --rm --name waterpi waterpi
```

*Launch everything*
```
$ docker-compose up --build
```
