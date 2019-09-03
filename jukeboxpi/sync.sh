#!/usr/bin/env bash
while sleep 1; do rsync -av --exclude ".*" /webdev/jgivoni/rpi-projects pi@jukeboxpi:/home/pi; done
