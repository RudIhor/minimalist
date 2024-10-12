.DEFAULT_GOAL := help

dc := docker compose
de := $(dc) exec

SHELL := /bin/bash

.PHONY: help
help: ## Display help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' Makefile | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: dm
dm: ## Drop merged branches
	git checkout dev && git branch --merged | grep -v \* | xargs git branch -D

.PHONY: construct
build-construct: ## Build images
	$(dc) up -d --build

.PHONY: up
up: ## Start application
	$(dc) up -d

.PHONY: down
down: ## Stop application
	$(dc) down

.PHONY: app-console
app-console: ## Go into app console
	$(de) app /bin/bash

.PHONY: webserver-console
webserver-console: ## Go into webserver console
	$(de) webserver /bin/bash

.PHONY: db-console
db-console: ## Go into db console
	$(de) db /bin/bash

.PHONY: restart
restart: ## Restart application
	$(dc) down; $(dc) up -d --build