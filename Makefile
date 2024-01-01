sail-up:
	./vendor/bin/sail up
php-serve:
	./vendor/bin/sail artisan serve
db-migrate:
	./vendor/bin/sail artisan migrate:fresh
db-seed:
	./vendor/bin/sail artisan db:seed
npm-install:
	npm install
