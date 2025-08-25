lint:
	php -d 'error_reporting=E_ALL & ~E_DEPRECATED' vendor/bin/phpcs --standard=PSR12 src

test:
	vendor/bin/phpunit --colors=always

test-coverage:
	phpunit --coverage-clover=coverage.xml
