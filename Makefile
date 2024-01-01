setup:
	@make cp-env
	@make sail-up
init:
	@make key
	@make composer-update
	@make db-migrate
	@make php-serve
	@make npm-install
	@make npm-run
cp-env:
	cp .env.example .env
sail-up:
	./vendor/bin/sail up
key:
	./vendor/bin/sail artisan key:generate 
composer-update:
	./vendor/bin/sail composer update
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