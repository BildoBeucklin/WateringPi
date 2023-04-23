#!/bin/bash
#Script tht creates a video from images
ffmpeg -framerate 60 -i ezgif-frame-%03d.jpg output.mp4
