.DEFAULT_GOAL: build

HOST := prod.loginwith.xyz
DOCKER_HOST=ssh://root@${HOST}

all: build

LAST_DEPLOYED=`date -u +"%Y-%m-%d %H:%M:%S UTC"`
GIT_REV=`git rev-parse --short HEAD``git diff --quiet || echo ' dirty'`

humans: public/humans.txt.in
	cat public/humans.txt.in | sed -e "s/__LAST_DEPLOYED__/$(LAST_DEPLOYED)/g" | sed -e "s/__GIT_REV__/$(GIT_REV)/g" > public/humans.txt

build: humans ./public/**.php
	docker build -t web:latest .

.PHONY: deploy
deploy:
	@echo "deploying to ${HOST}"
	@sleep 1
	docker stop `docker ps --filter "label=app=web" -q` || true
	docker run -d --restart=unless-stopped -p 127.0.0.1:80:80 -p 443:443 --read-only -v /root/web/data:/app/data -v /tmp:/tmp -v /root/.local:/root/.local -v /root/.config:/root/.config web:latest

.PHONY:
shell:
	docker exec -it `docker ps --filter "label=app=web" -q` bash

.PHONY:
logs:
	docker logs -f `docker ps --filter "label=app=web" -q`
