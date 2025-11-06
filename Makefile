install:
	composer install

validate:
	composer validate

dump:
	composer dump-autoload -o

lint:
	composer exec --verbose phpcs -- src tests
	composer exec --verbose phpstan

lint-fix:
	composer exec --verbose phpcbf -- src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --bootstrap vendor/autoload.php --coverage-filter src --coverage-clover=coverage.xml tests
	
test-coverage-text:
	XDEBUG_MODE=coverage vendor/bin/phpunit --bootstrap vendor/autoload.php --coverage-text tests
	