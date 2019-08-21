**TinkerPi**

*Install dependencies*
```
$ docker run --rm -it \
    --volume $PWD:/app \
    --user $(id -u):$(id -g) \
    composer install
```

*Build app*
```
$ docker build -t <pi-name> .
```

*Run app*
```
$ docker run -it --rm --name <pi-name> <pi-name>
```

*Launch everything*
```
$ docker-compose up --build
$ docker-compose up -d --build
```
