# Changelog - Rent Cars

Toutes les modifications notables apportées au projet seront documentées dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère à [Semantic Versioning](https://semver.org/lang/fr/).

## [1.0.0] - 2026-01-05

### 🎉 Version initiale - Dockerisation complète avec CI/CD

#### Ajouté
- **Dockerisation complète**
  - Dockerfile de production (PHP 8.2 FPM + extensions PostgreSQL)
  - Dockerfile.dev pour développement (avec Xdebug)
  - docker-compose.yaml avec 3 services (PHP, Nginx, PostgreSQL)
  - Configuration Nginx pour FastCGI
  - Configuration PHP personnalisée (opcache, memory_limit, etc.)
  
- **Migration de base de données**
  - Migration de SQLite vers PostgreSQL 16 pour meilleure compatibilité Docker
  - Configuration Doctrine pour PostgreSQL
  - Fichiers .env.local et .env.test pour environnements Docker
  
- **Tests automatisés**
  - Tests unitaires (VehiculeTest, ReservationTest)
  - Tests d'intégration (VehiculeRepositoryTest)
  - Tests fonctionnels (HomeControllerTest, CatalogueControllerTest)
  - Configuration PHPUnit avec couverture de code
  - Base de données de test séparée
  
- **Pipeline CI/CD GitLab**
  - Stage `install` : Installation des dépendances Composer
  - Stage `test` : Exécution de PHPUnit avec PostgreSQL
  - Stage `test` : Analyse de code (PHP_CodeSniffer, PHPStan)
  - Stage `build` : Construction de l'image Docker
  - Stage `docker` : Push automatique sur Docker Hub (branche main)
  - Cache et artifacts pour optimisation
  - Gestion sécurisée des secrets (variables masked)
  
- **Documentation complète**
  - README.md : Guide complet d'utilisation
  - QUICK_START.md : Démarrage rapide
  - DEVOPS_REPORT_GUIDE.md : Plan du rapport académique (15-20 pages)
  - VALIDATION_CHECKLIST.md : Checklist de validation
  - EXECUTIVE_SUMMARY.md : Résumé exécutif
  - .env.example : Exemple de configuration
  
- **Scripts automatisés**
  - start.ps1 : Script PowerShell de démarrage automatique
  - run-tests.ps1 : Script PowerShell d'exécution des tests
  - Makefile : Commandes simplifiées pour Docker
  
- **Dépendances**
  - symfony/http-client : Pour le chatbot AI
  
#### Modifié
- composer.json : Ajout de symfony/http-client
- .gitignore : Adaptation pour Docker et PostgreSQL
- phpunit.dist.xml : Configuration améliorée avec environnement de test
- config/packages/doctrine.yaml : Support PostgreSQL

#### Technique
- **Architecture** : PHP 8.2 FPM + Nginx + PostgreSQL 16
- **Orchestration** : Docker Compose avec healthchecks et volumes persistants
- **CI/CD** : GitLab CI/CD avec 4 stages et 6 jobs
- **Tests** : PHPUnit 12 avec couverture de code (Xdebug)
- **Déploiement** : Docker Hub automatique sur merge vers main

---

## Structure des versions

### [Version majeure.mineure.patch]

- **Majeure** : Changements incompatibles avec les versions précédentes
- **Mineure** : Ajout de fonctionnalités rétrocompatibles
- **Patch** : Corrections de bugs rétrocompatibles

### Types de changements

- **Ajouté** : Nouvelles fonctionnalités
- **Modifié** : Changements dans les fonctionnalités existantes
- **Déprécié** : Fonctionnalités bientôt supprimées
- **Supprimé** : Fonctionnalités supprimées
- **Corrigé** : Corrections de bugs
- **Sécurité** : Correctifs de vulnérabilités

---

## Roadmap future (suggestions)

### [1.1.0] - À venir
- [ ] Ajout de Kubernetes (k8s) pour l'orchestration en production
- [ ] Intégration de Prometheus + Grafana pour monitoring
- [ ] Tests de charge avec JMeter ou Gatling
- [ ] Scan de sécurité avec Trivy ou Snyk
- [ ] Environnement de staging automatique

### [1.2.0] - À venir
- [ ] Migration vers PHP 8.3
- [ ] Ajout de Redis pour le cache
- [ ] Ajout de RabbitMQ pour les messages asynchrones
- [ ] API REST avec API Platform
- [ ] Documentation OpenAPI/Swagger

---

## Notes de migration

### Migration de SQLite vers PostgreSQL

**Raison** : PostgreSQL est plus adapté pour :
- Environnements Docker (conteneur officiel avec healthcheck)
- Tests parallèles (isolation des bases de données)
- Production (scalabilité, transactions ACID, performances)
- Standard industriel pour Symfony

**Impact** : Les migrations Doctrine sont compatibles. Les fixtures doivent être rechargées.

**Commandes** :
```bash
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

---

## Contributeurs

- Équipe de développement Rent Cars
- Projet académique DevOps 2026

---

## Licence

Propriétaire - Usage académique uniquement

