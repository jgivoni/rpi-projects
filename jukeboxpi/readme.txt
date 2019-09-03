Create directory for project
$ mkdir ~/jukebox

Attach USB camera
$ sudo apt-get install fswebcam
$ sudo apt-get install zbar-tools
($ sudo apt-get install libzbar-dev? this might not be necessary?)

Script to grab images, scan them and save the code in a log file
$ vi ~/jukebox/capture-qr-code.sh
#!/bin/bash
while :
do
     fswebcam -q -r 640x480 --no-banner --jpeg 95 -S 25 --greyscale /home/pi/jukebox/qr-code.jpg
     zbarimg -q /home/pi/jukebox/qr-code.jpg | sed s/^.*:// >> /home/pi/jukebox/qr-code.log
done

Make it executable
$ chmod 777 ~/jukebox/capture-qr-code.sh

Start script
$ nohup /home/pi/jukebox/capture-qr-code.sh &

See scanned qr code images in a webbrowser
Make symlink from web dir to jukebox
$ sudo ln -s /home/pi/jukebox /var/www/html/jukebox

Browse to image
http://jukeboxpi/jukebox/qr-code.jpg
http://192.168.0.23/jukebox/qr-code.jpg

Attach gcloud to transfer songs
$ sudo vi /etc/hosts
192.168.0.98 naspi

$ sudo vi /etc/fstab
naspi:/media/usb /mnt/gcloud nfs rsize=32768,wsize=32768,hard,intr,nosuid,noatime 0 0

Create mount point
$ sudo mkdir gcloud

Enable
$ sudo mount /mnt/gcloud

Copy songs
$ mkdir ~/jukebox/songs
Copy mp3 files to ~/jukebox/songs and rename them to a 3 digit number, ex:
* 001.mp3
* 002.mp3
* 003.mp3

Play mp3 over USB audio
$ sudo apt-get install mpg321

Configure ALSA
$ sudo vi /etc/asound.conf
pcm.!default {
     type hw
     card 1
}
ctl.!default {
     type hw
     card 1
}

Attach the USB speakers!

Enable it
$ sudo alsactl restore 1

Test sound
$ mpg321 "/mnt/gcloud/audio/music/artists/hijkl/Lou Reed/Transformer/07 Satellite Of Love.mp3"

Detect QR code card and trigger song play
Create daemon script
$ vi ~/jukebox/detect-and-play.sh

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

Make it executable
$ chmod 777 ~/jukebox/detect-and-play.sh

Set up autostart on reboot
$ crontab -e
@reboot /home/pi/jukebox/capture-qr-code.sh > /var/log/jukebox.log 2>&1
@reboot /home/pi/jukebox/detect-and-play.sh >> /var/log/jukebox.log 2>&1

$ sudo touch jukebox.log
$ sudo chmod 777 jukebox.log

Generate codes
http://www.qr-code-generator.com/

Songs on Tim’s jukebox

Print cards:
https://docs.google.com/drawings/d/1HQFDTLgpFmgtnrFcs0in0T17JNq6hlUoTINsBjsFNg4/edit


