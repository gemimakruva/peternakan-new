.SILENT:

DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_FILE = docker-compose.yml
DOCKER_PHP_CONTAINER_EXEC= $(DOCKER_COMPOSE) exec app

DOCKER_PHP_EXECUTABLE_CMD = php

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan
CMD_COMPOSER = $(DOCKER_PHP_EXECUTABLE_CMD) -dmemory_limit=1G /usr/bin/composer

up: ## Start all or c=<name> containers in foreground
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) up $(c)

start: ## Start all or c=<name> containers in background
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) up -d $(c)

stop: ## Stop all or c=<name> containers
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) stop $(c)

status: ## Show status of containers
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) ps

rebuild:
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) up -d --build 

restart: ## Restart all or c=<name> containers
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) stop $(c)
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) up $(c) -d

logs: ## Show logs for all or c=<name> containers
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) logs --tail=100 -f $(c)

clean: confirm ## Clean all data
	@$(DOCKER_COMPOSE) -f $(DOCKER_COMPOSE_FILE) down

install:
ifeq (,$(wildcard ./vendor/))
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_COMPOSER) install --prefer-dist
endif
ifeq (, $(wildcard ./.env))
	cp .env.example .env
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) key:generate
endif
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) migrate:fresh
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) db:seed

reset-db:
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) migrate:fresh --seed

reset: reset-db

test-unit:
ifeq (,$(wildcard ./database/database.sqlite))
	$(DOCKER_PHP_CONTAINER_EXEC) touch ./database/database.sqlite
endif
	$(DOCKER_PHP_CONTAINER_EXEC) php -d memory_limit=512M ./vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration ./phpunit.xml --no-coverage

test-coverage:
	$(DOCKER_PHP_CONTAINER_EXEC) php -d xdebug.mode=coverage -d memory_limit=512M ./vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration ./phpunit.xml \
		--coverage-html tests/build/coverage

pint-v:
	@$(DOCKER_PHP_CONTAINER_EXEC) php -d memory_limit=512M ./vendor/bin/pint -v 

pint-test:
	@$(DOCKER_PHP_CONTAINER_EXEC) php -d memory_limit=512M ./vendor/bin/pint --test 

bash:
	@$(DOCKER_PHP_CONTAINER_EXEC) bash
