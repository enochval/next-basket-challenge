PROJECT_NAME="next-basket-challenge"
USER_SERVICE_DOCKER_COMPOSE=docker-compose -p $(PROJECT_NAME) -f ./etc/docker/user-service-docker-compose.yml

## ----------------------
## Docker composer management
## ----------------------

.PHONY: build
build: ## Build the stack
	$(USER_SERVICE_DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: ## Environment up!
	$(USER_SERVICE_DOCKER_COMPOSE) up -d --build --force-recreate --renew-anon-volumes

.PHONY: destroy
destroy:
	$(USER_SERVICE_DOCKER_COMPOSE) down --remove-orphans --volumes
	$(USER_SERVICE_DOCKER_COMPOSE) rm --stop --volumes --force

## ----------------------
## Laravel commands
## ----------------------

.PHONY: migrate
migrate:
	$(USER_SERVICE_DOCKER_COMPOSE) exec app bash -c "php ./api/artisan migrate"