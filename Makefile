# Makefile pour simplifier les commandes Docker du projet Rent Cars
# Usage: make <target>

.PHONY: help start stop restart build install migrate fixtures test test-unit test-integration test-functional logs clean

# Couleurs pour l'affichage
BLUE := \033[0;34m
GREEN := \033[0;32m
YELLOW := \033[0;33m
RED := \033[0;31m
NC := \033[0m # No Color

help: ## Afficher cette aide
	@echo "$(BLUE)Commandes disponibles pour Rent Cars:$(NC)"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  $(GREEN)%-20s$(NC) %s\n", $$1, $$2}'

start: ## Démarrer tous les conteneurs Docker
	@echo "$(YELLOW)Démarrage des conteneurs...$(NC)"
	docker-compose up -d --build
	@echo "$(GREEN)✓ Conteneurs démarrés$(NC)"
	@echo "$(BLUE)Application disponible sur: http://localhost:8080$(NC)"

stop: ## Arrêter tous les conteneurs
	@echo "$(YELLOW)Arrêt des conteneurs...$(NC)"
	docker-compose down
	@echo "$(GREEN)✓ Conteneurs arrêtés$(NC)"

restart: stop start ## Redémarrer tous les conteneurs

build: ## Reconstruire les images Docker
	@echo "$(YELLOW)Reconstruction des images...$(NC)"
	docker-compose build --no-cache
	@echo "$(GREEN)✓ Images reconstruites$(NC)"

install: ## Installer les dépendances Composer
	@echo "$(YELLOW)Installation des dépendances...$(NC)"
	docker-compose exec php composer install --optimize-autoloader
	@echo "$(GREEN)✓ Dépendances installées$(NC)"

migrate: ## Créer la base de données et exécuter les migrations
	@echo "$(YELLOW)Création de la base de données...$(NC)"
	docker-compose exec php php bin/console doctrine:database:create --if-not-exists --no-interaction
	@echo "$(YELLOW)Exécution des migrations...$(NC)"
	docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
	@echo "$(GREEN)✓ Migrations appliquées$(NC)"

fixtures: ## Charger les données de test
	@echo "$(YELLOW)Chargement des fixtures...$(NC)"
	docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
	@echo "$(GREEN)✓ Fixtures chargées$(NC)"

setup: start install migrate fixtures ## Installation complète (start + install + migrate + fixtures)
	@echo "$(GREEN)✓ Installation complète terminée!$(NC)"
	@echo "$(BLUE)Application disponible sur: http://localhost:8080$(NC)"

test: ## Exécuter tous les tests
	@echo "$(YELLOW)Exécution de tous les tests...$(NC)"
	docker-compose exec php php bin/phpunit --testdox
	@echo "$(GREEN)✓ Tests terminés$(NC)"

test-unit: ## Exécuter les tests unitaires
	@echo "$(YELLOW)Exécution des tests unitaires...$(NC)"
	docker-compose exec php php bin/phpunit tests/Unit --testdox

test-integration: ## Exécuter les tests d'intégration
	@echo "$(YELLOW)Exécution des tests d'intégration...$(NC)"
	docker-compose exec php php bin/phpunit tests/Integration --testdox

test-functional: ## Exécuter les tests fonctionnels
	@echo "$(YELLOW)Exécution des tests fonctionnels...$(NC)"
	docker-compose exec php php bin/phpunit tests/Functional --testdox

test-coverage: ## Générer le rapport de couverture de code
	@echo "$(YELLOW)Génération de la couverture de code...$(NC)"
	docker-compose exec php php bin/phpunit --coverage-html coverage
	@echo "$(GREEN)✓ Rapport généré dans coverage/index.html$(NC)"

logs: ## Afficher les logs de tous les conteneurs
	docker-compose logs -f

logs-php: ## Afficher les logs PHP
	docker-compose logs -f php

logs-nginx: ## Afficher les logs Nginx
	docker-compose logs -f nginx

logs-db: ## Afficher les logs PostgreSQL
	docker-compose logs -f database

shell: ## Accéder au shell du conteneur PHP
	docker-compose exec php bash

db-shell: ## Accéder au shell PostgreSQL
	docker-compose exec database psql -U app -d app

cache-clear: ## Effacer le cache Symfony
	@echo "$(YELLOW)Effacement du cache...$(NC)"
	docker-compose exec php php bin/console cache:clear
	@echo "$(GREEN)✓ Cache effacé$(NC)"

clean: ## Arrêter et supprimer tous les conteneurs et volumes
	@echo "$(RED)Arrêt et suppression de tous les conteneurs et volumes...$(NC)"
	docker-compose down -v
	@echo "$(GREEN)✓ Nettoyage terminé$(NC)"

ps: ## Afficher le statut des conteneurs
	docker-compose ps

stats: ## Afficher les statistiques d'utilisation des conteneurs
	docker stats rent_cars_php rent_cars_nginx rent_cars_db

validate: ## Valider la configuration Docker Compose
	docker-compose config

ci-test: ## Exécuter les tests comme dans le CI/CD
	@echo "$(YELLOW)Simulation du pipeline CI/CD...$(NC)"
	docker-compose exec php composer install --no-interaction --optimize-autoloader
	docker-compose exec php php bin/console doctrine:database:create --if-not-exists --env=test --no-interaction
	docker-compose exec php php bin/console doctrine:migrations:migrate --env=test --no-interaction
	docker-compose exec php php bin/phpunit --coverage-text --colors=never
	@echo "$(GREEN)✓ Tests CI/CD terminés$(NC)"

