Developing this image

Build the docker image for Raspberry Pi
```
$ docker image build -t jgivoni/rpi-gpio-server .
```

Run the docker container as a service on port 7695 in the foreground
```
$ docker run -it --rm --device=/dev/gpiomem -p 7695:7695 jgivoni/rpi-gpio-server
$ docker run -it --rm --privileged -p 7695:7695 jgivoni/rpi-gpio-server
```

Push the image to the Docker Hub
```
$ docker image tag jgivoni/rpi-gpio-server jgivoni/rpi-gpio-server:XXX
$ docker login
$ docker push jgivoni/rpi-gpio-server
```
