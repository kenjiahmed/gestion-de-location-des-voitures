# 📋 GUIDE COMPLET DEVOPS - Rapport Académique

## 📸 CAPTURES D'ÉCRAN REQUISES

### 1. Docker & Dockerization
- [ ] `docker-compose ps` montrant les 3 conteneurs UP (nginx, php, db)
- [ ] Structure des fichiers Docker (Dockerfile, docker-compose.yml)
- [ ] Logs de démarrage `docker-compose up`
- [ ] Application fonctionnelle sur http://localhost:8081

### 2. GitLab CI/CD
- [ ] Fichier `.gitlab-ci.yml` complet
- [ ] Pipeline GitLab avec les 4 stages (install, test, build, docker)
- [ ] Logs de chaque stage en succès
- [ ] Job de tests unitaires réussi
- [ ] Job de tests d'intégration réussi
- [ ] Job de build Docker réussi

### 3. Tests
- [ ] Résultat `php bin/phpunit` montrant tous les tests OK
- [ ] Couverture de code (si disponible)
- [ ] Structure des dossiers tests/ (Unit, Integration, Functional)

### 4. Docker Hub
- [ ] Job GitLab "push_to_dockerhub" réussi
- [ ] Image visible sur Docker Hub avec le tag
- [ ] Commande `docker pull` de votre image

### 5. Application Fonctionnelle
- [ ] Page d'accueil
- [ ] Page catalogue avec véhicules
- [ ] Page de réservation
- [ ] Espace admin

---

## 📝 PLAN DU RAPPORT (10-15 pages)

### Page de Garde
- Titre du projet
- Nom et prénom
- Date
- Logo de l'école

### Table des matières
1. Introduction
2. Architecture du projet
3. Dockerization
4. Tests automatisés
5. CI/CD avec GitLab
6. Déploiement Docker Hub
7. Conclusion

---

### 1. INTRODUCTION (1 page)
**À écrire :**
- Contexte du projet (location de voitures)
- Objectifs DevOps :
  - Containerisation avec Docker
  - Tests automatisés
  - Intégration continue (CI)
  - Déploiement continu (CD)
- Technologies utilisées :
  - PHP 8.3
  - Symfony 7
  - PostgreSQL 15
  - Docker & Docker Compose
  - GitLab CI/CD
  - PHPUnit

---

### 2. ARCHITECTURE DU PROJET (2 pages)

#### 2.1 Architecture Applicative
**Schéma à inclure :**
```
Client (Navigateur)
      ↓
   Nginx (Port 8081)
      ↓
   PHP-FPM 8.3
      ↓
PostgreSQL 15
```

**À expliquer :**
- Pattern MVC avec Symfony
- Entités : Vehicule, User, Reservation, Brand, Category, Image
- Controllers : Home, Catalogue, Admin, Reservation, Security
- Services : EntityManager, Repository, Forms

#### 2.2 Architecture Docker
**Schéma à inclure :**
```
docker-compose.yml
     ├── nginx (port 8081)
     ├── php (PHP 8.3-FPM)
     └── postgres (PostgreSQL 15)
```

**À expliquer :**
- Chaque conteneur a un rôle spécifique
- Communication via réseau Docker interne
- Persistence des données avec volumes Docker

---

### 3. DOCKERIZATION (3 pages)

#### 3.1 Dockerfile
**Capture d'écran du Dockerfile**

**À expliquer :**
```dockerfile
FROM php:8.3-fpm
# Installation des extensions PHP nécessaires
# Installation de Composer
# Configuration de l'environnement
```

**Points importants :**
- Image de base : `php:8.3-fpm`
- Extensions installées : pdo_pgsql, zip, intl, opcache
- Optimisations pour la production

#### 3.2 Docker Compose
**Capture d'écran du docker-compose.yml**

**Services configurés :**
1. **nginx** :
   - Port exposé : 8081
   - Configuration custom dans `docker/nginx/default.conf`
   
2. **php** :
   - Build depuis Dockerfile.dev
   - Volumes : code source monté
   - Dépend de : postgres
   
3. **postgres** :
   - Image officielle PostgreSQL 15
   - Persist

ance : volume `database_data`
   - Variables d'environnement sécurisées

#### 3.3 Commandes Docker
**Captures d'écran des commandes :**
```bash
docker-compose build
docker-compose up -d
docker-compose ps
docker-compose logs
```

---

### 4. TESTS AUTOMATISÉS (2 pages)

#### 4.1 Structure des Tests
**Capture d'écran de l'arborescence tests/**
```
tests/
├── Unit/           # Tests unitaires
├── Integration/    # Tests d'intégration  
└── Functional/     # Tests fonctionnels
```

#### 4.2 Tests Unitaires
**Exemples de tests :**
- `VehiculeTest` : Test des getters/setters
- `ReservationTest` : Test de création
- `UserTest` : Test d'authentification

**Capture du résultat :**
```
PHPUnit 11.5
Time: 00:02.145
Tests: 10, Assertions: 10, OK
```

#### 4.3 Tests d'Intégration
- Tests des repositories
- Tests des requêtes Doctrine
- Tests avec base de données

#### 4.4 Couverture de Code
**Si disponible, ajouter :**
- Pourcentage de couverture
- Rapport HTML de couverture

---

### 5. CI/CD AVEC GITLAB (3 pages)

#### 5.1 Pipeline GitLab CI
**Capture d'écran du fichier `.gitlab-ci.yml`**

**Les 4 stages :**
1. **install** : Installation des dépendances Composer
2. **test** : Exécution des tests (unit, integration, quality)
3. **build** : Construction de l'image Docker
4. **docker** : Publication sur Docker Hub

#### 5.2 Stage Install
**Capture d'écran du job réussi**

**À expliquer :**
```yaml
install_dependencies:
  - composer install
  - artifacts sauvegardés (vendor/)
```

#### 5.3 Stage Test
**3 jobs en parallèle :**

1. **unit_tests**
   - Service PostgreSQL  
   - Migrations
   - Tests unitaires

2. **integration_tests**
   - Service PostgreSQL
   - Fixtures chargées
   - Tests d'intégration

3. **code_quality**
   - Analyse statique
   - PHPStan / Psalm (si configuré)

**Capture de chaque job réussi**

#### 5.4 Stage Build
**Capture du job build_docker_image**

**À expliquer :**
- Construction de l'image Docker
- Tag avec $CI_COMMIT_SHA
- Conditions : branches main/develop uniquement

#### 5.5 Stage Docker
**Capture du job push_to_dockerhub**

**À expliquer :**
- Login à Docker Hub avec credentials GitLab
- Push de l'image taguée
- Déclenchement manuel (when: manual)
- Condition : branche main uniquement

---

### 6. DÉPLOIEMENT DOCKER HUB (1 page)

#### 6.1 Configuration des Variables CI
**Dans GitLab CI/CD Settings > Variables :**
- `DOCKER_HUB_USERNAME`
- `DOCKER_HUB_PASSWORD`

#### 6.2 Image sur Docker Hub
**Capture d'écran :**
- Image visible sur hub.docker.com
- Tags disponibles (latest, SHA)
- Informations de l'image

#### 6.3 Pull et Test de l'Image
**Commandes :**
```bash
docker pull username/rent_cars:latest
docker run -d -p 8081:80 username/rent_cars:latest
```

---

### 7. BONNES PRATIQUES DEVOPS (1 page)

**Implémentées dans ce projet :**
- ✅ Infrastructure as Code (Docker Compose)
- ✅ CI/CD automatisé (GitLab)
- ✅ Tests automatisés (PHPUnit)
- ✅ Versioning des images Docker
- ✅ Séparation des environnements (dev/prod/test)
- ✅ Utilisation de secrets (variables CI)
- ✅ Pipeline reproductible
- ✅ Rollback possible (tags Docker)

---

### 8. CONCLUSION (1 page)

**À résumer :**
- Objectifs atteints :
  - ✅ Application Dockerisée
  - ✅ Tests automatisés fonctionnels
  - ✅ Pipeline CI/CD opérationnel
  - ✅ Image disponible sur Docker Hub
  
- Compétences acquises :
  - Docker & Docker Compose
  - GitLab CI/CD
  - Tests automatisés
  - DevOps best practices

- Améliorations possibles :
  - Monitoring (Prometheus/Grafana)
  - Orchestration (Kubernetes)
  - Sécurité renforcée
  - Performance optimisée

---

## 🎯 CHECKLIST AVANT SOUMISSION

### Fichiers du projet
- [ ] `.gitlab-ci.yml` présent et fonctionnel
- [ ] `Dockerfile` optimisé
- [ ] `docker-compose.yml` complet
- [ ] `README.md` à jour
- [ ] Tests fonctionnels (au moins 5 tests unitaires)

### GitLab
- [ ] Repository GitLab créé
- [ ] Code pushé
- [ ] Pipeline exécuté avec succès
- [ ] Variables CI/CD configurées
- [ ] Image poussée sur Docker Hub

### Documentation
- [ ] Rapport PDF de 10-15 pages
- [ ] Toutes les captures d'écran incluses
- [ ] Schémas d'architecture
- [ ] Code commenté
- [ ] README clair et complet

### Démonstration
- [ ] Application démarre avec `docker-compose up`
- [ ] Tests passent avec `docker-compose exec php php bin/phpunit`
- [ ] Admin accessible
- [ ] CRUD fonctionnel

---

## 🚀 COMMANDES RAPIDES POUR LA DÉMO

```bash
# 1. Démarrer l'application
docker-compose up -d

# 2. Vérifier les conteneurs
docker-compose ps

# 3. Lancer les tests
docker-compose exec php php bin/phpunit

# 4. Voir les logs
docker-compose logs -f

# 5. Accéder au conteneur PHP
docker-compose exec php bash

# 6. Arrêter proprement
docker-compose down
```

---

## 📌 VARIABLES GITLAB CI À CONFIGURER

Dans **Settings > CI/CD > Variables** :
- `DOCKER_HUB_USERNAME` : Votre nom d'utilisateur Docker Hub
- `DOCKER_HUB_PASSWORD` : Votre mot de passe Docker Hub (masqué)

**Type** : Variable  
**Environment scope** : All  
**Protect variable** : ✅  
**Mask variable** : ✅ (pour le password)

---

## ✅ CRITÈRES D'ÉVALUATION

1. **Dockerization (30%)** :
   - Dockerfile correct
   - docker-compose.yml fonctionnel
   - Application accessible

2. **Tests (20%)** :
   - Tests unitaires
   - Tests d'intégration
   - Couverture >50%

3. **CI/CD (30%)** :
   - Pipeline GitLab fonctionnel
   - Stages correctement définis
   - Tests automatisés dans la CI

4. **Docker Hub (10%)** :
   - Image publiée
   - Tags corrects
   - Pull fonctionnel

5. **Documentation (10%)** :
   - Rapport complet
   - Captures d'écran
   - Clarté des explications

---

**Bon courage pour votre présentation ! 🎓**

