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