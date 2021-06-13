#!/usr/bin/env bash
# Start the project like this without needing docker-compose
docker run -d --privileged --restart unless-stopped --log-driver json-file --log-opt max-size=10m --log-opt max-file=3 --name gpio jgivoni/rpi-gpio-server
docker run -d --restart unless-stopped -v "`pwd`:/usr/src/app" --link gpio --log-driver json-file --log-opt max-size=10m --log-opt max-file=3 --name app welcomepi
