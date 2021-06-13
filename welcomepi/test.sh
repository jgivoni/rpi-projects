#!/usr/bin/env bash
# Start the project like this without needing docker-compose
docker run -d --privileged --name gpio -p 7695:7695 jgivoni/rpi-gpio-server
docker run -d -v "`pwd`:/usr/src/app" --link gpio --name app welcomepi php ./test.php
