#!/bin/bash
truncate /home/pi/jukebox/qr-code.log --size 0
OLDCODE=
tail -f /home/pi/jukebox/qr-code.log | while read CODE
do
  echo "Code detected: ${CODE}"
  if
    [[ ${CODE} != ${OLDCODE} ]] || ! ps x | grep -v grep | grep -qs mpg321;
  then
    sudo pkill mpg321
    mpg321 -q "/home/pi/jukebox/songs/${CODE}.mp3" &
    OLDCODE=${CODE}
  fi
done
