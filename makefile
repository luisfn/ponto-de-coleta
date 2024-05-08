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
	$(DOCKER_COMPOSE) logs -f nginx

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
	@echo "  start          Start Symfony development server"
	@echo "  stop           Stop Symfony development server"
	@echo "  install        Install PHP dependencies using Composer"
	@echo "  update         Update PHP dependencies using Composer"
	@echo "  clear-cache    Clear Symfony cache"
	@echo "  cmd            Run Symfony console commands (usage: make cmd cmd=\"your:symfony:command\")"
	@echo "  test           Run PHPunit tests"
	@echo "  create-db      Create database schema"
	@echo "  drop-db        Drop database schema"
	@echo "  update-db      Update database schema"
	@echo "  load-fixtures  Load fixtures (if using DoctrineFixturesBundle)"
	@echo "  migrate        Run migrations (if using DoctrineMigrationsBundle)"
	@echo "  deploy         Run all necessary steps to prepare the application for production"
	@echo "  help           Show this help message"

.PHONY: start stop install update clear-cache cmd test create-db drop-db update-db load-fixtures migrate deploy help
