#!/usr/bin/env bash
while sleep 1; do rsync -av --exclude ".*" /webdev/jgivoni/rpi-projects pi@welcomepi2:/home/pi; done
