PWD:=$(shell pwd)
CONFIG:=$(PWD)/config
VOLUMES:=$(PWD)/../booothy-volumes

BOOOTHY_USER=`cat .env | grep MONGODB_BOOOTHY_USER | sed "s/^MONGODB\_BOOOTHY\_USER=//"`
BOOOTHY_PASS=`cat .env | grep MONGODB_BOOOTHY_PASS | sed "s/^MONGODB\_BOOOTHY\_PASS=//"`

build-booothy-images:
	docker build -f $(CONFIG)/docker/Dockerfile.fpm -t booothy-php/7.0.7-fpm-alpine .

run-network:
	docker network create booothy-network

run-booothy-mongodb:
	docker run --rm -it \
	--name=booothy-mongodb \
	--net=booothy-network \
	--volume=$(VOLUMES)/mongodb:/data/db \
	-e MONGODB_USER=$(BOOOTHY_USER) \
	-e MONGODB_PASS=$(BOOOTHY_PASS) \
	-e MONGODB_DATABASE="booothy" \
	tutum/mongodb:3.2

run-booothy:
	docker run --rm -it \
	--name=booothy-fpm \
	--net=booothy-network \
	--volume=$(PWD):/var/www/booothy \
	--volume=$(VOLUMES)/booothy/tmp:/var/booothy/tmp \
	--volume=$(VOLUMES)/booothy/logs:/var/booothy/logs \
	--volume=$(VOLUMES)/booothy/cache/twig:/var/booothy/cache/twig \
	--volume=$(VOLUMES)/booothy/cache/profiler:/var/booothy/cache/profiler \
	--volume=$(VOLUMES)/booothy/uploads:/var/booothy/uploads \
	--volume=$(VOLUMES)/booothy/uploads/thumbs:/var/booothy/uploads/thumbs \
	booothy-php/7.0.7-fpm-alpine

run-nginx:
	docker run --rm -it \
	--name=booothy-nginx \
	--net=booothy-network \
	--volume=$(PWD)/web:/var/www/booothy/web \
	--volume=$(CONFIG)/ssl:/etc/ssl:ro \
	--volume=$(CONFIG)/nginx/booothy.conf:/etc/nginx/conf.d/booothy.conf:ro \
	--volume=$(VOLUMES)/booothy/uploads:/var/booothy/uploads:ro \
	-p 80:80 \
	-p 443:443 \
	nginx:1.11.0-alpine
