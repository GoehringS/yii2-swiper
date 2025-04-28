install:
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 install

update:
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 update

stop:
	docker compose down

phpstan:
	docker compose up -d
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 update phpstan/phpstan
	docker compose run php_runtime vendor/bin/phpstan analyse assets demos helpers tests

php-cs-fixer:
	docker compose up -d
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 update friendsofphp/php-cs-fixer
	docker compose run php_runtime vendor/bin/php-cs-fixer fix --ansi --verbose --diff

php-cs-fixer-dry-run:
	docker compose up -d
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 update friendsofphp/php-cs-fixer
	docker compose run php_runtime vendor/bin/php-cs-fixer fix --ansi --verbose --diff --dry-run

phpunit:
	docker compose up -d
	docker run --rm --interactive --tty --volume $$PWD:/app composer:2 update phpunit/phpunit
	docker compose run php_runtime vendor/bin/phpunit