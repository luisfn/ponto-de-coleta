# Symfony project name
PROJECT_NAME = "Ponto de Coleta"

# Symfony CLI binary
SYMFONY = symfony

# PHP binary
PHP = php

# Composer binary
COMPOSER = composer

# Symfony CLI command
SYMFONY_CMD = $(PHP) bin/console

# Docker Compose binary
DOCKER_COMPOSE = docker-compose

# Execute a command in a Docker service container
EXEC = $(DOCKER_COMPOSE) exec -T

# Start Symfony development server
start:
	$(DOCKER_COMPOSE) up -d

# Stop Symfony development server
stop:
	$(DOCKER_COMPOSE) down

# Restart Symfony development server
make restart:
	$(DOCKER_COMPOSE) down
	$(DOCKER_COMPOSE) up -d

# Show Symfony development server logs
logs:
	$(DOCKER_COMPOSE) logs -f $(container)

dev-logs:
	$(EXEC) php tail -f var/log/dev.log

# Install PHP dependencies using Composer
install:
	$(EXEC) php $(COMPOSER) install

# Update PHP dependencies using Composer
update:
	$(EXEC) php $(COMPOSER) update

# Clear Symfony cache
clear-cache:
	$(EXEC) php $(SYMFONY_CMD) cache:clear

# Warm Symfony cache
warm-cache:
	$(EXEC) php $(SYMFONY_CMD) cache:warmup

# Load fixtures
fixtures:
	$(EXEC) php $(SYMFONY_CMD) doctrine:fixtures:load

# Run PHPunit tests
test:
	$(EXEC) php $(PHP) bin/phpunit

# Open a shell in the PHP service container
shell:
	docker-compose exec php bash

autoload:
	$(EXEC) php $(COMPOSER) dump-autoload

# Create database schema
create-db:
	$(EXEC) php $(SYMFONY_CMD) doctrine:database:create --if-not-exists

# Drop database schema
drop-db:
	$(EXEC) php $(SYMFONY_CMD) doctrine:database:drop --force --if-exists

# Update database schema
update-db:
	$(EXEC) php $(SYMFONY_CMD) doctrine:schema:update --force

# Load fixtures (if using DoctrineFixturesBundle)
load-fixtures:
	$(EXEC) php $(SYMFONY_CMD) doctrine:fixtures:load --no-interaction

# Run migrations (if using DoctrineMigrationsBundle)
migrate:
	$(EXEC) php $(SYMFONY_CMD) doctrine:migrations:migrate --no-interaction

# Run all necessary steps to prepare the application for production
deploy: clear-cache install migrate

# Help command
help:
	@echo "Usage: make [target]"
	@echo ""
	@echo "Available targets:"
	@echo "  start          Start Symfony development server using Docker Compose"
	@echo "  stop           Stop Symfony development server"
	@echo "  restart        Restart Symfony development server"
	@echo "  logs           Show Docker Compose logs"
	@echo "  dev-logs       Tail development logs"
	@echo "  install        Install PHP dependencies using Composer in the Docker environment"
	@echo "  update         Update PHP dependencies using Composer"
	@echo "  clear-cache    Clear Symfony cache"
	@echo "  warm-cache     Warm up Symfony cache"
	@echo "  test           Run PHPunit tests"
	@echo "  shell          Open a bash shell in the PHP service container"
	@echo "  autoload       Dump Composer autoload"
	@echo "  create-db      Create database schema if it does not exist"
	@echo "  drop-db        Forcefully drop database schema if it exists"
	@echo "  update-db      Forcefully update database schema"
	@echo "  load-fixtures  Load Doctrine fixtures without interaction"
	@echo "  migrate        Run Doctrine migrations without interaction"
	@echo "  deploy         Prepare application for production by running necessary steps"
	@echo "  help           Show this help message"

.PHONY: start stop install update clear-cache warm-cache test shell autoload create-db drop-db update-db load-fixtures migrate deploy help