Developing this image

## Build the docker image for Raspberry Pi
Build from scratch directly on the Raspberry!
```
$ docker image build -t jgivoni/rpi-gpio-server .
```

You may build an incremental image from any host:
````
$ docker image build -f Dockerfile2 -t jgivoni/rpi-gpio-server:3 .
```

## Run the docker container as a service on port 7695 in the foreground
```
$ docker run -it --rm --privileged -p 7695:7695 jgivoni/rpi-gpio-server
```

## Push the image to the Docker Hub
```
$ docker image tag jgivoni/rpi-gpio-server jgivoni/rpi-gpio-server:XXX
$ docker login
$ docker push jgivoni/rpi-gpio-server
```
