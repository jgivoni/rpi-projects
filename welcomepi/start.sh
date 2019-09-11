#!/usr/bin/env bash
# Start the project like this without needing docker-compose
docker run -d --privileged --restart unless-stopped --name gpio jgivoni/rpi-gpio-server
docker run -d --restart unless-stopped -v "`pwd`:/usr/src/app" --link gpio --name app welcomepi
