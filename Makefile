install:
	composer install

lint:
	vendor/bin/phpcs --standard=PSR12 src tests

lint-fix:
	vendor/bin/phpcbf --standard=PSR12 src tests

test:
	vendor/bin/phpunit --no-coverage

test-coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-clover build/logs/clover.xml
