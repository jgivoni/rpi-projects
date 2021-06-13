#!/usr/bin/env bash
# Stop the containers
docker stop app && docker rm app
docker stop gpio && docker rm gpio
