PHP_IMAGE_NAME := php:8.1-fpm-alpine-eu141

build:
	docker build --network=host -f Dockerfile.php-fpm -t $(PHP_IMAGE_NAME) .

clean:
	docker system prune

exec:
	docker exec -it job-site_php /bin/sh

dbshell:
	docker exec -it job-site_mariadb mysql -ujob -p

composer.phar:
	@wget -O composer.phar -q https://getcomposer.org/download/2.2.7/composer.phar
	@chmod +x $@
	@touch $@

.PHONY: all build clean exec


