PROJECT_NAME="next-basket"
USER_SERVICE_DOCKER_COMPOSE=docker-compose -p $(PROJECT_NAME)-user -f ./etc/docker/user-service-docker-compose.yml
NOTIFICATIONS_SERVICE_DOCKER_COMPOSE=docker-compose -p $(PROJECT_NAME)-notification -f ./etc/docker/notification-service-docker-compose.yml

## ----------------------
## Docker composer management
## ----------------------

.PHONY: build
build: ## Build the stack
	$(USER_SERVICE_DOCKER_COMPOSE) build --no-cache
	$(NOTIFICATIONS_SERVICE_DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: ## Environment up!
	$(USER_SERVICE_DOCKER_COMPOSE) up -d --build --force-recreate --renew-anon-volumes
	$(NOTIFICATIONS_SERVICE_DOCKER_COMPOSE) up -d --build --force-recreate --renew-anon-volumes

.PHONY: destroy
destroy:
	$(USER_SERVICE_DOCKER_COMPOSE) down --remove-orphans --volumes
	$(USER_SERVICE_DOCKER_COMPOSE) rm --stop --volumes --force

	$(NOTIFICATIONS_SERVICE_DOCKER_COMPOSE) down --remove-orphans --volumes
	$(NOTIFICATIONS_SERVICE_DOCKER_COMPOSE) rm --stop --volumes --force

## ----------------------
## Laravel commands
## ----------------------

.PHONY: migrate
migrate:
	$(USER_SERVICE_DOCKER_COMPOSE) exec app bash -c "php ./api/artisan migrate --force"

.PHONY: test
test:
	$(USER_SERVICE_DOCKER_COMPOSE) exec app bash -c "./vendor/bin/pest"
	$(USER_SERVICE_DOCKER_COMPOSE) exec app bash -c "./vendor/bin/phpunit ./api/"