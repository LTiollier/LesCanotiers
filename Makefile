#!make
include .env
export $(shell sed 's/=.*//' .env)

# INSTALLS
update: vendor package-lock.json public/js/vendor.js
	make migrate

## install
install: .env vendor node_modules public/js/vendor.js
	php artisan key:generate

## install database
install_db:
	echo 'CREATE DATABASE IF NOT EXISTS `$(DB_DATABASE)`' | mysql -u$(DB_USERNAME) -p$(DB_PASSWORD) -h$(DB_HOST)
	echo 'CREATE DATABASE IF NOT EXISTS `$(DB_DATABASE_TEST)`' | mysql -u$(DB_USERNAME_TEST) -p$(DB_PASSWORD_TEST) -h$(DB_HOST)
	make fresh

## build ci
build_ci: .env vendor
	php artisan key:generate

## reset project
reset:
	composer install
	npm install
	rm -rf public/js/*.js
	rm -rf public/css/*.css
	npm run dev
	make fresh
	php artisan cache:clear
	php artisan config:clear

## code analysis
testing:
	- ./vendor/bin/security-checker security:check
	- ./vendor/bin/phpcs --report=full
	- ./vendor/bin/psalm

test:
	- php artisan test

# DEPENDANCES
## env
.env:
	cp .env.example .env

## lance un Code Sniffer
cssee:
	./vendor/bin/phpcs

## code analyse
stan:
	./vendor/bin/phpstan analyse --memory-limit=2G

## security check
secucheck:
	./vendor/bin/security-checker security:check

##
# Database
##

## migration migrate
migrate:
	php artisan migrate
	php artisan migrate --database mysql_test

## migration roll back
rollback:
	php artisan migrate:rollback
	php artisan migrate:rollback --database mysql_test

## refresh database
refresh:
	php artisan migrate:refresh --seed
	php artisan migrate:refresh --database mysql_test

##  fresh
fresh:
	php artisan migrate:fresh --seed
	php artisan migrate:fresh --database mysql_test

#####
# Javascript
######

## install node module
node_modules:
	npm install

public/js/vendor.js:
	npm run dev

## composer install
vendor: composer.json composer.lock
	composer install

package-lock.json:
	npm install

# Help instructions
help:
	@echo "\033[0;33mUsage:\033[0m"
	@echo "     make [target]\n"
	@echo "\033[0;33mAvailable targets:\033[0m"
	@awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		returnMessage = match(n4line, /^# (.*)/); \
		if (returnMessage) { \
			printf "\n"; \
			printf "     %s\n", n5line; \
			printf "     %s\n", n4line; \
			printf "     %s\n", n3line; \
			printf "\n"; \
		} \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "     \033[0;32m%-22s\033[0m %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ n5line = n4line; n4line = n3line; n3line = n2line; n2line = lastLine; lastLine = $$0;}' $(MAKEFILE_LIST)
	@echo ""

