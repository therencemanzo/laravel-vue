setup:
	@make cp-env
	@make composer-update
	@make sail-up

init:
	@make key
	@make db-migrate
	@make db-seed
	@make npm-install
	@make npm-run


cp-env:
	cp .env.example .env
composer-update:
	composer update
sail-up:
	./vendor/bin/sail up

key:
	./vendor/bin/sail artisan key:generate 
db-migrate:
	./vendor/bin/sail artisan migrate:fresh
php-serve:
	./vendor/bin/sail artisan serve
db-seed:
	./vendor/bin/sail artisan db:seed
npm-install:
	npm install
npm-run:
	npm run dev