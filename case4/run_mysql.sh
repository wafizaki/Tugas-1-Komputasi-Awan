#!/bin/sh

docker rm -f mysql1

docker network create mynet || true

docker container run \
	-dit \
	--name mysql1 \
	--network mynet \
	-v $(pwd)/dbdata:/var/lib/mysql \
	-v $(pwd)/init.sql:/docker-entrypoint-initdb.d/init.sql \
	-e MYSQL_DATABASE=mydb \
	-e MYSQL_PASSWORD=mydb6789tyui \
	-e MYSQL_ROOT_PASSWORD=mydb6789tyui \
	-e MYSQL_ROOT_HOST=% \
        mysql:8.0-debian 
