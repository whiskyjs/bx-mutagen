install:
	composer install --no-interaction --prefer-dist

update:
	composer update

test:
	composer test

analyze:
	composer analyze

lint:
	composer lint

check:
	composer test && composer analyze && composer lint
