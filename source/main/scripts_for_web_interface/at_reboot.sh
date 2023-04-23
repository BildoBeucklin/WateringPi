#!/bin/bash

stty -F /dev/ttyACM0 cs8 38400 ignbrk -brkint -imaxbel -opost -onlcr -isig -icanon -iexten -echo -echoe -echok -echoctl -echoke noflsh -ixon -crtscts

echo "done"
