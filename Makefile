.PHONY=clean test

clean:
	rm -rf vendor
	rm -rf composer.lock

test:
	composer update;
	composer install;
	vendor/bin/phpunit tests/;

coverage:
	composer update
	composer install
	vendor/bin/phpunit --coverage-html=/tmp/coverage/ tests/
