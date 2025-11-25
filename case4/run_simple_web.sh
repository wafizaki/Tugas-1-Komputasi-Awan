#!/bin/sh

docker rm -f webserver1

docker network create mynet || true

docker container run \
	-d \
	--name webserver1 \
	--network mynet \
	-p 8080:80 \
	-v $(pwd)/files:/var/www/html \
	php:7.4-apache \
	/bin/sh -c "docker-php-ext-install mysqli && apache2-foreground"

