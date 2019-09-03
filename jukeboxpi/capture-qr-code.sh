#!/bin/bash
while :
do
     fswebcam -q -r 640x480 --no-banner --jpeg 95 --greyscale -S 25 /home/pi/jukebox/qr-code.jpg
     zbarimg -q /home/pi/jukebox/qr-code.jpg | sed s/^.*:// >> /home/pi/jukebox/qr-code.log
done
