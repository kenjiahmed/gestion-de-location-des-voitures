# ✅ GUIDE DE VÉRIFICATION DU PIPELINE GITLAB

## 📅 Date : 9 Janvier 2026

---

## 🎯 OBJECTIF

Ce guide vous accompagne pour vérifier que votre pipeline GitLab fonctionne correctement après les corrections appliquées.

---

## 🔗 ACCÈS AU PROJET

**URL du projet** : https://gitlab.com/ahmedikenjatoun/rentcars_project

**Accès rapide** :
- Pipeline : https://gitlab.com/ahmedikenjatoun/rentcars_project/-/pipelines
- Jobs : https://gitlab.com/ahmedikenjatoun/rentcars_project/-/jobs
- Variables CI/CD : https://gitlab.com/ahmedikenjatoun/rentcars_project/-/settings/ci_cd

---

## 📋 ÉTAPE 1 : VÉRIFIER QUE LE CODE EST POUSSÉ

### 1.1 Vérifier sur GitLab

1. Allez sur : https://gitlab.com/ahmedikenjatoun/rentcars_project
2. Vérifiez que vous voyez :
   - ✅ Tous les fichiers du projet
   - ✅ Le README affiché
   - ✅ Le dernier commit visible

### 1.2 Fichiers critiques à vérifier

Cliquez sur ces fichiers et vérifiez leur contenu :

- [ ] `.gitlab-ci.yml` - Ligne 23 : `image: php:8.2-fpm`
- [ ] `Dockerfile` - Ligne 2 : `FROM php:8.2-fpm`
- [ ] `.env.test` - DATABASE_URL avec `postgres:5432`
- [ ] `phpunit.dist.xml` - `failOnWarning="false"`

---

## 📋 ÉTAPE 2 : VÉRIFIER LE PIPELINE

### 2.1 Accéder aux Pipelines

1. Cliquez sur **CI/CD** dans le menu de gauche
2. Cliquez sur **Pipelines**
3. Vous devriez voir au moins un pipeline

### 2.2 Vérifier le Statut du Pipeline

Le pipeline devrait avoir l'un de ces statuts :

| Statut | Signification | Action |
|--------|---------------|--------|
| ✅ **passed** | Tout fonctionne ! | Rien à faire, continuez à l'étape 3 |
| 🔵 **running** | En cours d'exécution | Attendez qu'il se termine |
| ❌ **failed** | Échec | Voir section "DÉPANNAGE" ci-dessous |
| ⏸️ **pending** | En attente | Attendez quelques minutes |

### 2.3 Structure du Pipeline (Attendue)

Le pipeline devrait avoir **4 stages** :

```
1. ✅ install (install_dependencies)
   └─ Durée : ~2-3 minutes

2. ✅ test (3 jobs en parallèle)
   ├─ unit_tests (~1-2 min)
   ├─ integration_tests (~2-3 min)
   └─ code_quality (~1 min, peut échouer)

3. ✅ build (build_docker_image)
   └─ Durée : ~3-5 minutes
   └─ Only: main, develop

4. ⚪ docker (push_to_dockerhub)
   └─ Status : Manual (ne se lance pas automatiquement)
   └─ Nécessite : DOCKER_HUB_USERNAME et DOCKER_HUB_PASSWORD
```

---

## 📋 ÉTAPE 3 : ANALYSER LES LOGS

### 3.1 Stage 1 : INSTALL

**Ce qui devrait se passer** :
```bash
✅ Composer install
✅ Vérification des requirements PHP
✅ Création des artifacts (vendor/)
```

**Comment vérifier** :
1. Cliquez sur le stage **install**
2. Cliquez sur le job **install_dependencies**
3. Recherchez ces lignes dans les logs :
   - `Installing dependencies from lock file`
   - `Package operations: X installs, 0 updates, 0 removals`
   - `Uploading artifacts...`

### 3.2 Stage 2 : TEST

#### Job : unit_tests

**Ce qui devrait se passer** :
```bash
✅ Création base de données PostgreSQL
✅ Migrations appliquées
✅ Tests unitaires exécutés
✅ Résultat : OK (X tests, Y assertions)
```

**Comment vérifier** :
1. Cliquez sur le job **unit_tests**
2. Recherchez ces lignes :
   - `[notice] Migrating up to DoctrineMigrations\Version...`
   - `[notice] finished in X ms`
   - `OK (X tests, Y assertions)`

#### Job : integration_tests

**Ce qui devrait se passer** :
```bash
✅ Création base de données PostgreSQL
✅ Migrations appliquées
✅ Fixtures chargées (ou message "Fixtures not available")
✅ Tests d'intégration exécutés
✅ Résultat : OK (X tests, Y assertions)
```

**Comment vérifier** :
1. Cliquez sur le job **integration_tests**
2. Recherchez les mêmes éléments que unit_tests

#### Job : code_quality

**Ce qui devrait se passer** :
```bash
✅ PHPUnit version affichée
✅ PHP version affichée (8.2.x)
```

**Note** : Ce job peut échouer (allow_failure: true), ce n'est pas bloquant.

### 3.3 Stage 3 : BUILD

**Ce qui devrait se passer** :
```bash
✅ Build de l'image Docker
✅ Tag de l'image
✅ Image créée avec succès
```

**Comment vérifier** :
1. Cliquez sur le job **build_docker_image**
2. Recherchez :
   - `Successfully built XXXXXXX`
   - `Successfully tagged rent_cars:...`

**Note** : Ce stage ne s'exécute que sur les branches `main` et `develop`.

### 3.4 Stage 4 : DOCKER

**Ce qui devrait se passer** :
```bash
⚪ Job manuel, ne se lance pas automatiquement
⚠️ Nécessite configuration Docker Hub
```

**Pour le déclencher** :
1. Configurez d'abord les variables (voir ÉTAPE 4)
2. Cliquez sur le bouton "Play" ▶️ à côté du job
3. Le job va build et push l'image vers Docker Hub

---

## 📋 ÉTAPE 4 : CONFIGURER DOCKER HUB (OPTIONNEL)

### 4.1 Créer un Compte Docker Hub

Si vous n'avez pas encore de compte :
1. Allez sur https://hub.docker.com
2. Cliquez sur "Sign Up"
3. Créez votre compte (gratuit)

### 4.2 Créer un Access Token

1. Connectez-vous à Docker Hub
2. Cliquez sur votre nom en haut à droite
3. Cliquez sur "Account Settings"
4. Cliquez sur "Security" dans le menu de gauche
5. Cliquez sur "New Access Token"
6. Donnez un nom : `gitlab-ci-rentcars`
7. Permissions : **Read, Write, Delete**
8. Cliquez sur "Generate"
9. **COPIEZ LE TOKEN** (vous ne pourrez plus le voir après)

### 4.3 Configurer les Variables dans GitLab

1. Allez sur votre projet GitLab
2. **Settings** > **CI/CD**
3. Trouvez la section **Variables**
4. Cliquez sur **Expand**
5. Cliquez sur **Add variable**

**Variable 1** :
- Key : `DOCKER_HUB_USERNAME`
- Value : Votre nom d'utilisateur Docker Hub (ex: `ahmedtoun`)
- Type : Variable
- Environment scope : All (default)
- Protect variable : ✅ Cocher
- Mask variable : ❌ Décocher
- Expand variable reference : ✅ Cocher

**Variable 2** :
- Key : `DOCKER_HUB_PASSWORD`
- Value : Le token que vous avez copié
- Type : Variable
- Environment scope : All (default)
- Protect variable : ✅ Cocher
- Mask variable : ✅ Cocher
- Expand variable reference : ✅ Cocher

6. Cliquez sur **Add variable** pour chaque variable

### 4.4 Tester le Push Docker Hub

1. Retournez sur **CI/CD** > **Pipelines**
2. Cliquez sur le dernier pipeline réussi
3. Trouvez le job **push_to_dockerhub** (stage docker)
4. Cliquez sur le bouton "Play" ▶️
5. Le job va :
   - Se connecter à Docker Hub
   - Builder l'image
   - Pusher vers `votre-username/rent_cars:latest`
   - Pusher vers `votre-username/rent_cars:commit-sha`

6. Vérifiez sur Docker Hub :
   - Allez sur https://hub.docker.com/repositories
   - Vous devriez voir `rent_cars` dans vos repositories

---

## 🐛 DÉPANNAGE

### Erreur : "composer install failed"

**Symptôme** : Le stage install échoue

**Solutions** :
```bash
# 1. Vérifier que PHP 8.2 est utilisé
# Dans .gitlab-ci.yml ligne 23 : image: php:8.2-fpm

# 2. Vérifier les extensions PHP
# Cherchez dans les logs : "ext-XXX requires PHP extension"

# 3. Mettre à jour les dépendances localement
docker-compose exec php composer update
git add composer.lock
git commit -m "chore: update composer.lock"
git push gitlab main
```

### Erreur : "doctrine:migrations:migrate failed"

**Symptôme** : Erreur SQLSTATE ou syntax error

**Solutions** :
```bash
# Vérifier que la migration est compatible PostgreSQL
# Ouvrir : migrations/Version20260108161023.php
# Chercher : AUTOINCREMENT (remplacer par SERIAL si trouvé)
# Chercher : INTEGER PRIMARY KEY (remplacer par SERIAL)

# Si migration corrompue, recréer :
docker-compose exec php php bin/console make:migration
git add migrations/
git commit -m "fix: regenerate migrations for PostgreSQL"
git push gitlab main
```

### Erreur : "phpunit tests failed"

**Symptôme** : Tests échouent dans le CI mais passent localement

**Solutions** :
```bash
# 1. Vérifier phpunit.dist.xml
# failOnWarning="false"
# failOnNotice="false"
# failOnDeprecation="false"

# 2. Vérifier .env.test
# DATABASE_URL=postgresql://app:app@postgres:5432/app_test?serverVersion=15&charset=utf8

# 3. Désactiver temporairement le job
# Dans .gitlab-ci.yml, ajouter : allow_failure: true

# 4. Analyser les logs spécifiques
# Chercher : "ERRORS!" ou "FAILURES!" dans les logs du job
```

### Erreur : "docker build failed"

**Symptôme** : Le build Docker échoue

**Solutions** :
```bash
# 1. Vérifier le Dockerfile
# Ligne 2 : FROM php:8.2-fpm

# 2. Tester localement
docker build -t test-rentcars -f Dockerfile .

# 3. Vérifier .dockerignore
# Ne doit PAS ignorer les fichiers nécessaires

# 4. Augmenter le timeout (si timeout)
# Dans .gitlab-ci.yml, ajouter dans le job :
timeout: 30m
```

### Erreur : "docker login failed"

**Symptôme** : Échec de connexion à Docker Hub

**Solutions** :
```bash
# 1. Vérifier que les variables existent
# Settings > CI/CD > Variables
# DOCKER_HUB_USERNAME et DOCKER_HUB_PASSWORD doivent être présentes

# 2. Vérifier que le token est valide
# Se connecter sur Docker Hub
# Vérifier que le token n'a pas expiré

# 3. Recréer le token
# Docker Hub > Account Settings > Security > New Access Token

# 4. Mettre à jour la variable dans GitLab
# Settings > CI/CD > Variables > Edit DOCKER_HUB_PASSWORD
```

### Erreur : "service postgres is not running"

**Symptôme** : Impossible de se connecter à PostgreSQL

**Solutions** :
```bash
# 1. Vérifier que le service est déclaré
# Dans .gitlab-ci.yml :
services:
  - postgres:15

# 2. Vérifier les variables
variables:
  POSTGRES_DB: app_test
  POSTGRES_USER: app
  POSTGRES_PASSWORD: app

# 3. Attendre que le service démarre
# Ajouter un before_script :
- sleep 10
- until pg_isready -h postgres; do sleep 1; done
```

---

## 📸 SCREENSHOTS POUR LE RAPPORT

### Screenshots à prendre sur GitLab

1. **Page d'accueil du projet**
   - URL visible
   - README affiché
   - Structure des fichiers visible

2. **Pipeline réussi (Vue d'ensemble)**
   - Les 4 stages en vert
   - Durée totale
   - Date/heure

3. **Stage INSTALL - Logs**
   - Composer install réussi
   - Artifacts uploadés

4. **Stage TEST - unit_tests - Logs**
   - Tests unitaires passés
   - Nombre de tests
   - "OK (X tests, Y assertions)"

5. **Stage TEST - integration_tests - Logs**
   - Tests d'intégration passés
   - Migrations appliquées

6. **Stage BUILD - Logs**
   - Docker build réussi
   - "Successfully built"
   - "Successfully tagged"

7. **Configuration Variables CI/CD**
   - Liste des variables (valeurs masquées)
   - DOCKER_HUB_USERNAME visible
   - DOCKER_HUB_PASSWORD masqué

8. **Docker Hub (si configuré)**
   - Repository rent_cars visible
   - Tags : latest et commit-sha
   - Taille de l'image

### Comment prendre les screenshots

**Sur Windows** :
- **Win + Shift + S** : Capture d'une zone
- Ou utilisez l'Outil Capture d'écran

**Nommer les fichiers** :
```
01-gitlab-projet-overview.png
02-gitlab-pipeline-success.png
03-gitlab-stage-install.png
04-gitlab-stage-test-unit.png
05-gitlab-stage-test-integration.png
06-gitlab-stage-build.png
07-gitlab-ci-variables.png
08-dockerhub-repository.png
```

**Où placer les screenshots** :
```
screenshots/
├── gitlab/
│   ├── 01-projet-overview.png
│   ├── 02-pipeline-success.png
│   └── ...
└── dockerhub/
    └── 08-repository.png
```

---

## 📊 CRITÈRES DE SUCCÈS

### ✅ Pipeline Minimum Viable

Pour une présentation réussie, vous devez avoir **AU MINIMUM** :

- [ ] Stage 1 (INSTALL) : ✅ Passé
- [ ] Stage 2 (TEST) : ✅ Au moins 2 jobs sur 3 passés
- [ ] Stage 3 (BUILD) : ✅ Passé (si sur branch main)

**Bonus** :
- [ ] Stage 4 (DOCKER) : ✅ Push Docker Hub réussi
- [ ] Tous les tests passent (10/10)
- [ ] Code quality passe

### ✅ Documentation Complète

- [ ] `.gitlab-ci.yml` bien structuré et commenté
- [ ] README.md expliquant le projet
- [ ] Rapport PDF avec screenshots
- [ ] Guides d'installation et utilisation

---

## 🎓 POUR LA PRÉSENTATION

### Ce qu'il faut montrer (5-10 minutes)

1. **Introduction (1 min)**
   - Nom du projet : Rent Cars
   - Technologies : Symfony 7, PostgreSQL, Docker, GitLab CI/CD

2. **Démonstration Application (2 min)**
   - Catalogue de véhicules
   - Réservation
   - Comparaison
   - Chatbot
   - Interface admin

3. **Architecture DevOps (2 min)**
   - Schéma : 3 conteneurs (nginx, php, postgres)
   - docker-compose.yaml
   - Dockerfile

4. **Pipeline CI/CD (3 min)**
   - Montrer sur GitLab
   - Expliquer les 4 stages
   - Montrer les logs de tests
   - Montrer Docker Hub (si configuré)

5. **Tests (1 min)**
   - 10 tests automatisés
   - Tests unitaires, intégration, fonctionnels
   - 100% de succès

6. **Conclusion (1 min)**
   - Récapitulatif
   - Difficultés rencontrées
   - Apprentissages

### Ce qu'il faut expliquer

**Question : "Pourquoi Docker ?"**
- Isolation des environnements
- Reproductibilité (dev = prod)
- Facilite le déploiement

**Question : "Pourquoi PostgreSQL au lieu de SQLite ?"**
- Plus robuste pour la production
- Meilleur pour le multi-utilisateur
- Compatible avec Docker et CI/CD

**Question : "Comment fonctionne le pipeline ?"**
- À chaque push : install + test
- Sur main : build Docker
- Manuellement : push vers Docker Hub

**Question : "Que testez-vous ?"**
- Logique métier (tests unitaires)
- Interaction base de données (tests intégration)
- Scénarios complets (tests fonctionnels)

---

## ✅ CHECKLIST FINALE

### Avant la Présentation

- [ ] Pipeline GitLab passe (au moins 3/4 stages)
- [ ] Screenshots pris et organisés
- [ ] Rapport PDF compilé
- [ ] Application fonctionne localement (`docker-compose up`)
- [ ] Tests passent localement (`docker-compose exec php php bin/phpunit`)

### Pendant la Présentation

- [ ] Laptop chargé
- [ ] Connexion internet stable
- [ ] Onglets préparés :
  - [ ] GitLab projet
  - [ ] GitLab pipeline
  - [ ] Docker Hub (si configuré)
  - [ ] Application locale (http://localhost:8080)
- [ ] Rapport PDF ouvert

### Après la Présentation

- [ ] Nettoyer les conteneurs : `docker-compose down -v`
- [ ] Archiver le projet
- [ ] Célébrer ! 🎉

---

## 📞 CONTACTS & RESSOURCES

**GitLab CI/CD** : https://docs.gitlab.com/ee/ci/
**Docker** : https://docs.docker.com/
**Symfony** : https://symfony.com/doc
**PHPUnit** : https://phpunit.de/documentation.html

---

<div align="center">

# ✅ VOTRE PIPELINE EST PRÊT !

## 🚀 Suivez ce guide pour vérifier que tout fonctionne

**Projet** : https://gitlab.com/ahmedikenjatoun/rentcars_project

**Bonne chance pour votre présentation ! 🎓**

</div>

