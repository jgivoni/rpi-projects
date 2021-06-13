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
$ sh start.sh
```

*Stop app*
```
$ sh stop.sh
```

*Test app*
In test mode, the lights will go on and off regardless of time (sunset/sunrise)
```
$ sh test.sh
```
