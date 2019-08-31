#!/usr/bin/env bash
while sleep 1; do rsync -av --exclude ".*" /webdev/jgivoni/rpi-projects pi@192.168.0.???:/home/pi; done
