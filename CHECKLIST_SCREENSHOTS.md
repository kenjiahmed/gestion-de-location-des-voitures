# 📸 CHECKLIST DES CAPTURES D'ÉCRAN REQUISES

**Projet** : Rent Cars - DevOps  
**Date** : 9 Janvier 2026

---

## 📋 INSTRUCTIONS GÉNÉRALES

- ✅ Faire des captures d'écran **claires** et **lisibles**
- ✅ Inclure la **barre d'adresse** du navigateur quand pertinent
- ✅ Montrer les **résultats complets** des commandes
- ✅ Annoter les captures si nécessaire
- ✅ Sauvegarder au format **PNG** ou **JPEG** haute qualité
- ✅ Nommer les fichiers de façon claire (ex: `01_docker_ps.png`)

---

## 🐳 PARTIE 1 : DOCKERISATION (5 screenshots)

### Screenshot 1 : Structure du Projet
**Fichier** : `01_structure_projet.png`  
**Action** :
- Ouvrir l'IDE (PhpStorm, VSCode, etc.)
- Afficher l'arborescence complète du projet
- Montrer les dossiers : `src/`, `tests/`, `docker/`, `config/`
- Capturer l'écran

**Éléments à vérifier** :
- ✅ Dossiers visibles : src, tests, docker, config, templates
- ✅ Fichiers visibles : Dockerfile, docker-compose.yml, .gitlab-ci.yml
- ✅ Lisibilité de la structure

---

### Screenshot 2 : Dockerfile
**Fichier** : `02_dockerfile.png`  
**Action** :
- Ouvrir le fichier `Dockerfile` dans l'IDE
- S'assurer que tout le contenu est visible
- Capturer l'écran

**Éléments à vérifier** :
- ✅ FROM php:8.2-fpm
- ✅ Instructions RUN pour extensions PHP
- ✅ COPY Composer
- ✅ WORKDIR /var/www/html

---

### Screenshot 3 : Docker Compose
**Fichier** : `03_docker_compose.png`  
**Action** :
- Ouvrir le fichier `docker-compose.yml` dans l'IDE
- S'assurer que tout le contenu est visible (services nginx, php, db)
- Capturer l'écran

**Éléments à vérifier** :
- ✅ Service nginx (port 8080)
- ✅ Service php (build Dockerfile.dev)
- ✅ Service db (postgres:15)
- ✅ Volumes déclarés

---

### Screenshot 4 : Conteneurs Actifs
**Fichier** : `04_docker_ps.png`  
**Action** :
```bash
docker-compose ps
```
- Lancer la commande dans le terminal
- Capturer la sortie montrant les 3 conteneurs

**Éléments à vérifier** :
- ✅ rent_cars_nginx (Up, 0.0.0.0:8080->80/tcp)
- ✅ rent_cars_php (Up)
- ✅ rent_cars_db (Up, healthy)
- ✅ STATUS = "Up" pour tous

**Alternative** : Capturer aussi `docker-compose logs --tail=20`

---

### Screenshot 5 : Application Fonctionnelle
**Fichier** : `05_app_running.png`  
**Action** :
- Ouvrir un navigateur
- Aller sur `http://localhost:8080`
- Capturer la page d'accueil de l'application

**Éléments à vérifier** :
- ✅ Page d'accueil chargée
- ✅ URL visible : http://localhost:8080
- ✅ Logo et navigation visibles
- ✅ Aucune erreur affichée

**Bonus** : Capturer aussi la page `/catalogue` pour montrer les véhicules

---

## 🧪 PARTIE 2 : TESTS AUTOMATISÉS (2 screenshots)

### Screenshot 6 : Résultat PHPUnit
**Fichier** : `06_phpunit_results.png`  
**Action** :
```bash
docker-compose exec php php bin/phpunit
```
- Lancer la commande dans le terminal
- Capturer la sortie complète montrant tous les tests

**Éléments à vérifier** :
- ✅ PHPUnit 11.5.0
- ✅ "OK (10 tests, 10 assertions)"
- ✅ Points verts : ..........
- ✅ Temps d'exécution
- ✅ Aucune erreur

**Exemple de sortie attendue** :
```
PHPUnit 11.5.0 by Sebastian Bergmann

..........                                                10 / 10 (100%)

Time: 00:02.145, Memory: 22.00 MB

OK (10 tests, 10 assertions)
```

---

### Screenshot 7 : Structure des Tests
**Fichier** : `07_tests_structure.png`  
**Action** :
- Ouvrir l'IDE
- Développer le dossier `tests/`
- Montrer les sous-dossiers : Unit/, Integration/, Functional/
- Capturer l'arborescence

**Éléments à vérifier** :
- ✅ tests/Unit/Entity/ (3 fichiers)
- ✅ tests/Integration/Repository/ (1 fichier)
- ✅ tests/Functional/Controller/ (2 fichiers)
- ✅ tests/bootstrap.php
- ✅ phpunit.dist.xml

---

## 🔄 PARTIE 3 : GITLAB CI/CD (5 screenshots)

### Screenshot 8 : Fichier .gitlab-ci.yml
**Fichier** : `08_gitlab_ci_file.png`  
**Action** :
- Ouvrir le fichier `.gitlab-ci.yml` dans l'IDE
- Montrer au moins les 4 stages
- Capturer l'écran

**Éléments à vérifier** :
- ✅ stages: [install, test, build, docker]
- ✅ Job install_dependencies
- ✅ Jobs de tests (unit, integration)
- ✅ Job build_docker_image
- ✅ Job push_to_dockerhub

---

### Screenshot 9 : Variables CI/CD GitLab
**Fichier** : `09_gitlab_variables.png`  
**Action** :
- Aller sur GitLab > Votre Projet > Settings > CI/CD > Variables
- Montrer les variables configurées
- **IMPORTANT** : Masquer les valeurs sensibles !
- Capturer l'écran

**Éléments à vérifier** :
- ✅ DOCKER_HUB_USERNAME (Protected)
- ✅ DOCKER_HUB_PASSWORD (Masked, Protected)
- ✅ Icône "masked" visible pour le password

---

### Screenshot 10 : Pipeline Complet
**Fichier** : `10_pipeline_overview.png`  
**Action** :
- Aller sur GitLab > Votre Projet > CI/CD > Pipelines
- Cliquer sur le dernier pipeline réussi
- Capturer la vue d'ensemble des 4 stages

**Éléments à vérifier** :
- ✅ 4 stages visibles : install, test, build, docker
- ✅ Tous les jobs en vert (passed)
- ✅ Durée totale du pipeline
- ✅ Commit SHA et branche (main)

---

### Screenshot 11 : Job Tests Réussi
**Fichier** : `11_job_tests.png`  
**Action** :
- Cliquer sur le job "unit_tests" ou "integration_tests"
- Capturer la sortie du job

**Éléments à vérifier** :
- ✅ Status: passed
- ✅ Logs du job visibles
- ✅ Résultat PHPUnit si visible
- ✅ Durée du job

---

### Screenshot 12 : Job Build Docker Réussi
**Fichier** : `12_job_build.png`  
**Action** :
- Cliquer sur le job "build_docker_image"
- Capturer la sortie du job

**Éléments à vérifier** :
- ✅ Status: passed
- ✅ Commandes docker build visibles
- ✅ Image taggée correctement
- ✅ Durée du job

---

## 📦 PARTIE 4 : DOCKER HUB (2 screenshots)

### Screenshot 13 : Image sur Docker Hub
**Fichier** : `13_dockerhub_image.png`  
**Action** :
- Se connecter sur https://hub.docker.com
- Aller sur votre repository (ex: username/rent_cars)
- Capturer la page du repository

**Éléments à vérifier** :
- ✅ Nom du repository visible
- ✅ Tags visibles (latest, commit SHA)
- ✅ Taille de l'image
- ✅ Date de dernière publication
- ✅ Nombre de pulls

---

### Screenshot 14 : Docker Pull Local
**Fichier** : `14_docker_pull.png`  
**Action** :
```bash
docker pull username/rent_cars:latest
```
- Lancer la commande dans le terminal
- Capturer la sortie complète

**Éléments à vérifier** :
- ✅ Téléchargement des layers
- ✅ Message "Status: Downloaded newer image..."
- ✅ Nom complet de l'image
- ✅ Tag "latest"

---

## 🎨 PARTIE 5 : FONCTIONNALITÉS APPLICATION (Bonus - 4 screenshots)

### Screenshot 15 : Page Catalogue
**Fichier** : `15_catalogue.png`  
**Action** :
- Naviguer vers http://localhost:8080/catalogue
- Capturer la page avec les véhicules

**Éléments à vérifier** :
- ✅ Liste de véhicules visible
- ✅ Filtres fonctionnels
- ✅ Pagination
- ✅ Boutons d'action (Réserver, Comparer)

---

### Screenshot 16 : Comparaison de Véhicules
**Fichier** : `16_compare.png`  
**Action** :
- Ajouter 2-3 véhicules à la comparaison
- Naviguer vers `/compare`
- Capturer la page de comparaison

**Éléments à vérifier** :
- ✅ Tableau de comparaison visible
- ✅ Images des véhicules
- ✅ Caractéristiques comparées
- ✅ Design moderne

---

### Screenshot 17 : Interface Admin
**Fichier** : `17_admin.png`  
**Action** :
- Se connecter en tant qu'administrateur
- Naviguer vers `/admin`
- Capturer le tableau de bord admin

**Éléments à vérifier** :
- ✅ Menu admin visible
- ✅ Liste des véhicules/réservations
- ✅ Boutons d'action (Modifier, Supprimer)
- ✅ Statistiques si présentes

---

### Screenshot 18 : Modes Clair/Sombre
**Fichier** : `18_dark_mode.png`  
**Action** :
- Activer le mode sombre
- Capturer la même page en mode clair et sombre (2 captures côte à côte)

**Éléments à vérifier** :
- ✅ Contraste clair/sombre visible
- ✅ Bouton toggle visible
- ✅ Design cohérent dans les deux modes

---

## 📊 RÉCAPITULATIF

### Captures d'écran obligatoires (14)

| # | Nom du fichier | Partie | Priorité |
|---|----------------|--------|----------|
| 1 | 01_structure_projet.png | Dockerisation | 🔴 Haute |
| 2 | 02_dockerfile.png | Dockerisation | 🔴 Haute |
| 3 | 03_docker_compose.png | Dockerisation | 🔴 Haute |
| 4 | 04_docker_ps.png | Dockerisation | 🔴 Haute |
| 5 | 05_app_running.png | Dockerisation | 🔴 Haute |
| 6 | 06_phpunit_results.png | Tests | 🔴 Haute |
| 7 | 07_tests_structure.png | Tests | 🟡 Moyenne |
| 8 | 08_gitlab_ci_file.png | CI/CD | 🔴 Haute |
| 9 | 09_gitlab_variables.png | CI/CD | 🔴 Haute |
| 10 | 10_pipeline_overview.png | CI/CD | 🔴 Haute |
| 11 | 11_job_tests.png | CI/CD | 🟡 Moyenne |
| 12 | 12_job_build.png | CI/CD | 🟡 Moyenne |
| 13 | 13_dockerhub_image.png | Docker Hub | 🔴 Haute |
| 14 | 14_docker_pull.png | Docker Hub | 🟡 Moyenne |

### Captures d'écran bonus (4)

| # | Nom du fichier | Partie | Priorité |
|---|----------------|--------|----------|
| 15 | 15_catalogue.png | Application | 🟢 Basse |
| 16 | 16_compare.png | Application | 🟢 Basse |
| 17 | 17_admin.png | Application | 🟢 Basse |
| 18 | 18_dark_mode.png | Application | 🟢 Basse |

---

## ✅ CHECKLIST DE VALIDATION

### Avant de capturer
- [ ] Docker containers en cours d'exécution
- [ ] Application accessible sur http://localhost:8080
- [ ] Tests passent avec succès
- [ ] GitLab CI configuré et pipeline exécuté
- [ ] Image Docker Hub publiée

### Qualité des captures
- [ ] Résolution suffisante (minimum 1280x720)
- [ ] Texte lisible
- [ ] Pas d'informations sensibles visibles (mots de passe, tokens)
- [ ] Format PNG ou JPEG
- [ ] Taille fichier raisonnable (< 2 MB par image)

### Organisation
- [ ] Toutes les captures nommées correctement
- [ ] Captures classées par section
- [ ] Légendes préparées pour le rapport
- [ ] Captures testées dans le document Word/PDF

---

## 📝 NOTES IMPORTANTES

### ⚠️ Sécurité
- **NE JAMAIS** capturer de mots de passe en clair
- **TOUJOURS** masquer les tokens et secrets
- **VÉRIFIER** avant de soumettre qu'aucune info sensible n'est visible

### 💡 Conseils
- Faire les captures en **plein écran** pour meilleure lisibilité
- Utiliser un **outil de capture** professionnel (Snagit, Greenshot, etc.)
- Ajouter des **annotations** si nécessaire (flèches, encadrés)
- Garder une **copie de backup** de toutes les captures

### 📅 Planning suggéré
1. **Jour 1** : Captures Docker et Tests (1h)
2. **Jour 2** : Captures GitLab CI/CD (2h - nécessite push et attente pipeline)
3. **Jour 3** : Captures Docker Hub et Application (1h)
4. **Jour 4** : Vérification et insertion dans le rapport (1h)

---

## 🎯 OBJECTIF FINAL

**14 captures obligatoires** pour démontrer :
- ✅ Maîtrise de Docker et containerisation
- ✅ Mise en place de tests automatisés
- ✅ Configuration CI/CD complète
- ✅ Déploiement sur registry Docker

**Bon courage pour vos captures d'écran ! 📸**

