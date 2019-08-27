**TinkerPi**

*Install dependencies*
```    
$ docker run --rm -it -v \
    "$(cd $(dirname "$1") && pwd -P)/$(basename "$1"):/app" \
    composer install --ignore-platform-reqs
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
