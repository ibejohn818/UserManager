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

docker-test-install:
	docker run --rm -it -v $(shell pwd):/code -w /code ibejohn818/php:php71w-build /bin/bash -c '/usr/bin/composer update && /usr/bin/composer install'

docker-test:
	docker run --rm -it -v $(shell pwd):/code -w /code ibejohn818/php:php71w-build /bin/bash -c 'vendor/bin/phpunit tests'

docker-coverage:
	docker run --rm -it -v $(shell pwd):/code -w /code ibejohn818/php:php71w-build /bin/bash -c 'vendor/bin/phpunit tests --coverage-html ./coverage'
