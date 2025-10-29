install:
	composer install

validate:
	composer validate

dump:
	composer dump-autoload -o

lint:
	composer exec -v phpcs src bin tests
	vendor/bin/phpstan analyse

link-fix:
	composer exec -v phpcbf ----standard=PSR12 --colors src bin tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	XDEBUG_MODE=coverage composer exec --verbose phpunit tests -- --coverage-clover=coverage.xml

test-coverage-text:
	composer test:coverage-text

test-coverage-html:
	composer test:coverage-html
	