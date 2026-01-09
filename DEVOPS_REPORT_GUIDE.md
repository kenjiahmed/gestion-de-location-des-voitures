# Rapport DevOps - Application Rent Cars

## Checklist des captures d'écran pour le rapport PDF

### 1. Dockerisation
- [ ] `docker-compose.yaml` - Configuration complète
- [ ] Résultat de `docker-compose ps` - Services actifs
- [ ] Résultat de `docker-compose logs` - Logs des conteneurs
- [ ] Page d'accueil http://localhost:8080 - Application fonctionnelle
- [ ] Structure des Dockerfiles (Dockerfile et Dockerfile.dev)
- [ ] Configuration Nginx (`docker/nginx/default.conf`)

### 2. Base de données PostgreSQL
- [ ] Configuration Doctrine (`config/packages/doctrine.yaml`)
- [ ] Fichier `.env` avec DATABASE_URL PostgreSQL
- [ ] Résultat de `docker-compose exec database psql -U app -d app -c "\dt"` - Tables créées
- [ ] Volume Docker pour la persistance

### 3. Tests
- [ ] Résultat de `docker-compose exec php php bin/phpunit` - Tous les tests passent
- [ ] Structure des tests (Unit, Integration, Functional)
- [ ] Configuration PHPUnit (`phpunit.dist.xml`)
- [ ] Rapport de couverture de code (si généré)

### 4. Pipeline GitLab CI/CD
- [ ] Fichier `.gitlab-ci.yml` complet
- [ ] Interface GitLab - Vue du pipeline (stages : install, test, build, docker)
- [ ] Job "install" - Installation des dépendances
- [ ] Job "test:unit" - Exécution des tests
- [ ] Job "code_quality" - Analyse statique
- [ ] Job "build:docker" - Construction de l'image
- [ ] Job "deploy:dockerhub" - Push sur Docker Hub (branche main)
- [ ] Logs de chaque job réussi

### 5. Variables CI/CD
- [ ] Configuration des variables GitLab (Settings > CI/CD > Variables)
  - DOCKER_HUB_USERNAME
  - DOCKER_HUB_PASSWORD

### 6. Docker Hub
- [ ] Page Docker Hub montrant l'image publiée
- [ ] Tags de l'image (latest, commit SHA)
- [ ] Commande `docker pull` réussie

### 7. Documentation
- [ ] README.md avec instructions complètes
- [ ] Structure du projet

---

## Plan du rapport académique

### Page de garde
- Titre : "Dockerisation et CI/CD d'une application Symfony"
- Nom du projet : Rent Cars
- Auteur(s)
- Date
- Logo de l'établissement

---

### 1. Introduction (1 page)

#### 1.1 Contexte du projet
- Description de l'application Rent Cars (location de véhicules)
- Technologies utilisées : Symfony 7.3, PostgreSQL, Docker
- Objectifs pédagogiques

#### 1.2 Problématique
- Besoin de containerisation pour la portabilité
- Automatisation des tests et du déploiement
- Intégration continue et livraison continue (CI/CD)

---

### 2. Architecture et Dockerisation (3-4 pages)

#### 2.1 Architecture de l'application
- Stack technique :
  - **PHP 8.2 FPM** : Traitement des requêtes PHP
  - **Nginx** : Serveur web
  - **PostgreSQL 16** : Base de données
- Schéma d'architecture (diagramme des conteneurs)

#### 2.2 Dockerisation
##### 2.2.1 Dockerfile de production
- Image de base : `php:8.2-fpm`
- Extensions PHP installées (PDO PostgreSQL, Zip, Opcache, Intl)
- Multi-stage build pour optimisation
- Bonnes pratiques : minimisation des couches, cache Composer

##### 2.2.2 Dockerfile de développement
- Ajout de Xdebug pour le debugging
- Configuration PHP pour le développement
- Hot-reload des fichiers

##### 2.2.3 Docker Compose
- Service PHP-FPM
- Service Nginx (port 8080)
- Service PostgreSQL avec healthcheck
- Volumes pour la persistance des données
- Réseau interne `rent_cars_network`

##### 2.2.4 Configuration Nginx
- Reverse proxy vers PHP-FPM
- Gestion des fichiers statiques
- Configuration FastCGI

#### 2.3 Migration SQLite → PostgreSQL
- Justification : meilleure compatibilité Docker, tests parallèles
- Modification du `DATABASE_URL`
- Mise à jour des fichiers `.env` et `.env.test`
- Gestion des migrations Doctrine

#### 2.4 Commandes de démarrage
```bash
docker-compose up -d --build
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate
docker-compose exec php php bin/console doctrine:fixtures:load
```

---

### 3. Stratégie de tests (2-3 pages)

#### 3.1 Types de tests implémentés

##### 3.1.1 Tests unitaires
- **Objectif** : Tester les entités et la logique métier isolément
- **Exemples** :
  - `VehiculeTest` : Création et relations
  - `ReservationTest` : Dates et statuts
- **Framework** : PHPUnit 12
- **Localisation** : `tests/Unit/`

##### 3.1.2 Tests d'intégration
- **Objectif** : Tester l'interaction avec la base de données
- **Exemples** :
  - `VehiculeRepositoryTest` : Requêtes Doctrine
- **Base de données** : PostgreSQL de test
- **Localisation** : `tests/Integration/`

##### 3.1.3 Tests fonctionnels
- **Objectif** : Tester les contrôleurs et les routes HTTP
- **Exemples** :
  - `HomeControllerTest` : Page d'accueil
  - `CatalogueControllerTest` : Listing des véhicules
- **Framework** : Symfony WebTestCase
- **Localisation** : `tests/Functional/`

#### 3.2 Configuration PHPUnit
- Fichier `phpunit.dist.xml`
- Environnement de test (APP_ENV=test)
- Base de données de test séparée
- Couverture de code activée

#### 3.3 Exécution des tests
```bash
# Localement avec Docker
docker-compose exec php php bin/phpunit

# Dans le pipeline CI/CD
php bin/phpunit --coverage-text --colors=never
```

#### 3.4 Résultats
- Nombre de tests : [X]
- Taux de couverture : [X]%
- Temps d'exécution : [X] secondes

---

### 4. Pipeline CI/CD GitLab (4-5 pages)

#### 4.1 Vue d'ensemble
- 4 stages : `install`, `test`, `build`, `docker`
- Objectif : automatiser de l'installation au déploiement

#### 4.2 Stage 1 : Install
- **Job** : `install`
- **Image** : `composer:latest`
- **Actions** :
  - `composer install`
  - `composer dump-autoload --optimize`
- **Artifacts** : `vendor/` (expire après 1h)
- **Cache** : `vendor/` et `.phpunit.cache/`

#### 4.3 Stage 2 : Test
##### 4.3.1 Job `test:unit`
- **Image** : `php:8.2-fpm`
- **Service** : `postgres:16-alpine`
- **Variables** :
  - `DATABASE_URL` : PostgreSQL de test
  - `APP_ENV=test`
- **Actions** :
  - Installation des extensions PHP
  - Création de la base de données de test
  - Exécution des migrations
  - Chargement des fixtures
  - Exécution de PHPUnit avec couverture
- **Coverage regex** : `/^\s*Lines:\s*\d+\.\d+\%/`

##### 4.3.2 Job `code_quality:phpcs`
- **Outil** : PHP_CodeSniffer
- **Standard** : PSR-12
- **Cible** : `src/`
- **Allow failure** : true (non bloquant)

##### 4.3.3 Job `code_quality:phpstan`
- **Outil** : PHPStan
- **Niveau** : 0 (peut être augmenté)
- **Cible** : `src/`
- **Allow failure** : true (non bloquant)

#### 4.4 Stage 3 : Build
##### 4.4.1 Job `build:docker`
- **Image** : `docker:24-cli`
- **Service** : `docker:24-dind` (Docker-in-Docker)
- **Actions** :
  - Construction de l'image Docker de production
  - Tag avec le SHA du commit
  - Tag `latest`
- **Déclenchement** : Toutes les branches et MR

#### 4.5 Stage 4 : Docker (Déploiement)
##### 4.5.1 Job `deploy:dockerhub`
- **Déclenchement** : Branche `main` uniquement
- **Condition** : Uniquement si les stages précédents réussissent
- **Actions** :
  - Connexion à Docker Hub (variables CI/CD)
  - Construction de l'image
  - Push avec 3 tags :
    - `<username>/rent_cars:latest`
    - `<username>/rent_cars:<commit-sha>`
    - `<username>/rent_cars:main`
  - Déconnexion Docker Hub

#### 4.6 Sécurité et bonnes pratiques
- **Variables secrètes** : Stockées dans GitLab CI/CD Variables (masked)
- **Cache** : Accélère les builds en réutilisant `vendor/`
- **Artifacts** : Partagés entre les jobs pour éviter la répétition
- **Docker-in-Docker** : Isolation complète pour construire des images
- **Fail fast** : Le pipeline échoue dès qu'un test échoue

#### 4.7 Améliorations possibles
- Ajout d'un stage de déploiement sur un serveur de staging
- Notifications Slack/Email en cas d'échec
- Tests de sécurité (OWASP, Dependabot)
- Analyse de performance (Blackfire)

---

### 5. Déploiement sur Docker Hub (2 pages)

#### 5.1 Configuration Docker Hub
- Création du compte Docker Hub
- Repository public ou privé : `<username>/rent_cars`
- Intégration avec GitLab via variables CI/CD

#### 5.2 Processus de déploiement
1. Commit et push sur la branche `main`
2. GitLab CI déclenche le pipeline
3. Tous les tests passent (jobs `install` et `test`)
4. Image Docker construite (job `build`)
5. Image poussée sur Docker Hub (job `deploy:dockerhub`)

#### 5.3 Utilisation de l'image déployée
```bash
# Pull de l'image depuis Docker Hub
docker pull <username>/rent_cars:latest

# Exécution en production
docker run -d -p 8080:80 \
  -e DATABASE_URL="postgresql://user:pass@host:5432/db" \
  -e APP_ENV=prod \
  -e APP_SECRET=<secret> \
  <username>/rent_cars:latest
```

#### 5.4 Versioning et tags
- `latest` : Dernière version stable (branche main)
- `<commit-sha>` : Version spécifique pour rollback
- `main` : Version de la branche principale

---

### 6. Résultats et démonstration (1-2 pages)

#### 6.1 Métriques du projet
- Nombre de conteneurs : 3 (PHP, Nginx, PostgreSQL)
- Taille de l'image Docker : ~XXX MB
- Temps de build : ~X minutes
- Nombre de tests : X (X unitaires, X intégration, X fonctionnels)
- Couverture de code : X%
- Temps d'exécution des tests : X secondes

#### 6.2 Captures d'écran
- Application fonctionnelle sur http://localhost:8080
- Pipeline GitLab réussi
- Image sur Docker Hub
- Tests passés avec succès

#### 6.3 Points forts du projet
- ✅ Conteneurisation complète (3 services)
- ✅ CI/CD fonctionnel de bout en bout
- ✅ Tests automatisés (3 niveaux)
- ✅ Déploiement automatique sur Docker Hub
- ✅ Documentation complète (README)
- ✅ Bonnes pratiques DevOps respectées

---

### 7. Difficultés rencontrées et solutions (1 page)

#### 7.1 Migration SQLite → PostgreSQL
- **Problème** : Incompatibilité de certaines requêtes SQL
- **Solution** : Utilisation de Doctrine ORM pour l'abstraction

#### 7.2 Configuration Docker-in-Docker
- **Problème** : Permissions et accès au daemon Docker
- **Solution** : Utilisation du service `docker:24-dind`

#### 7.3 Tests avec base de données
- **Problème** : Isolation des tests et données partagées
- **Solution** : Base de données de test séparée + fixtures

#### 7.4 Gestion des secrets
- **Problème** : Sécurisation des credentials Docker Hub
- **Solution** : Variables CI/CD masked dans GitLab

---

### 8. Conclusion et perspectives (1 page)

#### 8.1 Objectifs atteints
- ✅ Dockerisation complète de l'application Symfony
- ✅ Pipeline CI/CD opérationnel
- ✅ Tests automatisés à 3 niveaux
- ✅ Déploiement continu sur Docker Hub
- ✅ Documentation technique complète

#### 8.2 Compétences acquises
- Maîtrise de Docker et Docker Compose
- Configuration de pipelines GitLab CI/CD
- Tests automatisés (unitaires, intégration, fonctionnels)
- Bonnes pratiques DevOps (cache, artifacts, secrets)
- Déploiement continu

#### 8.3 Perspectives d'amélioration
- Ajout d'un environnement de staging
- Monitoring avec Prometheus + Grafana
- Orchestration avec Kubernetes
- Tests de charge (JMeter, Gatling)
- Sécurité renforcée (scan de vulnérabilités)

---

### Annexes

#### Annexe A : Fichiers de configuration
- `docker-compose.yaml`
- `.gitlab-ci.yml`
- `Dockerfile` et `Dockerfile.dev`
- `phpunit.dist.xml`

#### Annexe B : Commandes utiles
- Commandes Docker
- Commandes Symfony
- Commandes Git

#### Annexe C : Références
- Documentation Docker : https://docs.docker.com
- Documentation GitLab CI : https://docs.gitlab.com/ee/ci/
- Documentation Symfony : https://symfony.com/doc/current/

---

### Bibliographie
- Docker Documentation
- GitLab CI/CD Best Practices
- Symfony Testing Documentation
- DevOps Handbook

---

**Total pages estimé : 15-20 pages**

---

## Conseils pour la présentation orale

### 1. Introduction (2 minutes)
- Présenter le projet Rent Cars
- Objectifs DevOps

### 2. Démonstration live (8 minutes)
- Démarrer l'application avec `docker-compose up`
- Montrer l'application sur http://localhost:8080
- Exécuter les tests : `docker-compose exec php php bin/phpunit`
- Montrer le pipeline GitLab (interface web)
- Montrer l'image sur Docker Hub

### 3. Architecture technique (3 minutes)
- Schéma Docker Compose (3 services)
- Expliquer le flux CI/CD (4 stages)

### 4. Résultats et métriques (2 minutes)
- Tests réussis
- Pipeline réussi
- Image déployée

### 5. Questions/Réponses (5 minutes)

---

**Durée totale : 20 minutes**


