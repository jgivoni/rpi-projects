Developing this image

## Build the docker image for Raspberry Pi
Build from scratch directly on the Raspberry!
```
$ docker image build -t jgivoni/rpi-gpio-server .
```

You may build an incremental image from any host:
```
$ docker image build -f Dockerfile2 -t jgivoni/rpi-gpio-server:3 .
```

## Run the docker container as a service on port 7695 in the foreground
```
$ docker run -it --rm --privileged -p 7695:7695 jgivoni/rpi-gpio-server
```

## Launch the container in development mode
```
$ docker-compose up -d
```
Follow the logs
```
$ docker container logs -f --tail 10 gpio
```
Execute a command from host
```
$ telnet 192.168.0.25 7695
{"init": [{"gpiomem": false}]};
{"open": [7, 0]}
{"open": [12, 1]}
{"read": [12]}
{"write": [7, 1]}

open 7 0
open 12 1
read 12
write 7 1
```
Restart the server after a change
```

```

Execute other arbitrary commands on the server
```
$ docker exec -it gpio sh
# npm install nodemon -g
```
Create new image from running container after making manual changes
```
$ docker commit gpio jgivoni/rpi-gpio-server:3-dev
```

## Push the image to the Docker Hub
```
$ docker image tag jgivoni/rpi-gpio-server jgivoni/rpi-gpio-server:XXX
$ docker login
$ docker push jgivoni/rpi-gpio-server
```
