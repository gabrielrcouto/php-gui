#!/bin/bash
docker run -it -v $PWD:/app -p 5901:5901 -w /app gabrielrcouto/docker-lazarus:latest /bin/bash