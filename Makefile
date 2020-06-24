composer.lock: composer.json
	composer update

vendor: composer.lock
	composer install

yarn.lock: package.json
	yarn upgrade

node_modules: yarn.lock
	yarn install --pure-lockfile

.PHONY: db fixture test install
db:
	php bin/console doctrine:database:drop --if-exists --no-interaction --force --quiet
	php bin/console doctrine:database:create --no-interaction --quiet
	php bin/console doctrine:migration:migrate --no-interaction --no-ansi --quiet

fixture: db
	php bin/console doctrine:fixtures:load --no-interaction --purge-with-truncate --no-ansi --quiet

test:
	php bin/phpunit

install: vendor node_modules db