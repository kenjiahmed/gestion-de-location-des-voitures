# 🚗 Rent Cars - Application de Location de Voitures

[![Pipeline Status](https://img.shields.io/badge/pipeline-passing-brightgreen)](https://gitlab.com/ahmedikenjatoun/rentcars_project/-/pipelines)
[![Docker](https://img.shields.io/badge/docker-ready-blue)](https://hub.docker.com)
[![Symfony](https://img.shields.io/badge/Symfony-7-black)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.2--FPM-purple)](https://www.php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue)](https://www.postgresql.org)

## 📋 Description

**Rent Cars** est une application web moderne de location de véhicules développée avec **Symfony 7**. Elle offre une expérience utilisateur complète avec un catalogue de véhicules, un système de réservation intelligent, une fonctionnalité de comparaison de véhicules, et un chatbot d'assistance.

Le projet est entièrement **containerisé avec Docker** et dispose d'un **pipeline CI/CD complet** avec GitLab pour une intégration et un déploiement continus.

---

## ✨ Fonctionnalités Principales

### 🎯 Côté Utilisateur
- ✅ **Catalogue de véhicules** avec filtres avancés (catégorie, marque, prix)
- ✅ **Système de réservation** avec validation des dates et disponibilité
- ✅ **Comparaison de véhicules** (jusqu'à 3 véhicules côte à côte)
- ✅ **Chatbot intelligent** pour assistance client en temps réel
- ✅ **Mode sombre/clair** pour une meilleure expérience
- ✅ **Design responsive** adapté mobile et desktop

### 🔐 Côté Administrateur
- ✅ **Dashboard administrateur** avec statistiques
- ✅ **Gestion des véhicules** (CRUD complet)
- ✅ **Gestion des catégories et marques**
- ✅ **Gestion des réservations**
- ✅ **Upload d'images multiples** par véhicule

---

## 🏗️ Architecture

### Architecture 3-Tiers

```
┌─────────────────────────────────────────────────────────────┐
│                    ARCHITECTURE 3-TIERS                      │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌─────────────┐     ┌─────────────┐     ┌──────────────┐  │
│  │             │     │             │     │              │  │
│  │   NGINX     │────▶│   PHP-FPM   │────▶│  PostgreSQL  │  │
│  │  (port 8080)│     │  (Symfony)  │     │  (port 5432) │  │
│  │             │     │             │     │              │  │
│  └─────────────┘     └─────────────┘     └──────────────┘  │
│   Serveur Web        Application Web     Base de Données   │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

### Stack Technique

- **Backend** : Symfony 7 (PHP 8.2-FPM)
- **Base de données** : PostgreSQL 15
- **Serveur Web** : Nginx (reverse proxy)
- **Containerisation** : Docker + Docker Compose
- **CI/CD** : GitLab CI/CD
- **Tests** : PHPUnit (Unitaires, Intégration, Fonctionnels)
- **ORM** : Doctrine
- **Template Engine** : Twig

---

## 🚀 Installation et Démarrage

### Prérequis

- Docker Desktop installé et démarré
- Git
- Ports 8080 et 5432 disponibles

### Installation Rapide

```bash
# 1. Cloner le repository
git clone https://gitlab.com/ahmedikenjatoun/rentcars_project.git
cd rentcars_project

# 2. Démarrer l'application avec Docker Compose
docker-compose up -d

# 3. Installer les dépendances
docker-compose exec php composer install

# 4. Exécuter les migrations
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# 5. Charger les données de test (optionnel)
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### Accès à l'Application

- **Application** : http://localhost:8080
- **Compte Admin par défaut** :
  - Email : `admin@rentcars.com`
  - Mot de passe : `admin123`

---

## 🧪 Tests

Le projet inclut une suite de tests complète :

### Exécuter Tous les Tests

```bash
docker-compose exec php php bin/phpunit
```

### Tests par Type

```bash
# Tests unitaires
docker-compose exec php php bin/phpunit tests/Unit

# Tests d'intégration
docker-compose exec php php bin/phpunit tests/Integration

# Tests fonctionnels
docker-compose exec php php bin/phpunit tests/Functional
```

### Couverture de Code

```bash
docker-compose exec php php bin/phpunit --coverage-html coverage
```

**Résultats des Tests :**
- ✅ 10 tests
- ✅ 10 assertions
- ✅ 100% de réussite

---

## 🔄 Pipeline CI/CD

Le projet utilise GitLab CI/CD avec **4 stages** :

```
STAGE 1: INSTALL
  └─ composer install
  └─ Cache des dépendances

STAGE 2: TEST (parallèle)
  ├─ Tests Unitaires
  ├─ Tests d'Intégration
  └─ Tests Fonctionnels

STAGE 3: BUILD
  └─ Construction de l'image Docker

STAGE 4: DOCKER
  └─ Push vers Docker Hub (main uniquement)
```

### Variables CI/CD à Configurer

Dans GitLab : **Settings > CI/CD > Variables**

| Variable | Description | Protected | Masked |
|----------|-------------|-----------|--------|
| `DOCKER_HUB_USERNAME` | Nom d'utilisateur Docker Hub | ✓ | ✗ |
| `DOCKER_HUB_PASSWORD` | Token d'accès Docker Hub | ✓ | ✓ |

---

## 📦 Docker

### Démarrer les Conteneurs

```bash
# Démarrer en arrière-plan
docker-compose up -d

# Voir les logs
docker-compose logs -f

# Arrêter les conteneurs
docker-compose down

# Reconstruire les images
docker-compose build --no-cache
```

### Accès aux Conteneurs

```bash
# Shell dans le conteneur PHP
docker-compose exec php bash

# Shell dans PostgreSQL
docker-compose exec db psql -U symfony -d symfony_db
```

---

## 📂 Structure du Projet

```
rent_cars/
├── src/                      # Code source Symfony
│   ├── Controller/           # Contrôleurs
│   ├── Entity/               # Entités Doctrine
│   ├── Repository/           # Repositories
│   ├── Form/                 # Formulaires
│   └── Security/             # Authentification
├── tests/                    # Tests automatisés
│   ├── Unit/                 # Tests unitaires
│   ├── Integration/          # Tests d'intégration
│   └── Functional/           # Tests fonctionnels
├── docker/                   # Configuration Docker
│   ├── nginx/                # Config Nginx
│   └── php/                  # Config PHP
├── templates/                # Templates Twig
├── public/                   # Assets publics
│   ├── css/                  # Styles
│   ├── js/                   # JavaScript
│   └── images/               # Images
├── config/                   # Configuration Symfony
├── migrations/               # Migrations Doctrine
├── Dockerfile                # Image Docker production
├── Dockerfile.dev            # Image Docker développement
├── docker-compose.yaml       # Orchestration Docker
├── .gitlab-ci.yml            # Pipeline CI/CD
└── README.md                 # Documentation
```

---

## 🗄️ Base de Données

### Entités Principales

- **User** : Utilisateurs et administrateurs
- **Vehicule** : Véhicules disponibles à la location
- **Category** : Catégories de véhicules (SUV, Berline, etc.)
- **Brand** : Marques de véhicules (Toyota, BMW, etc.)
- **Reservation** : Réservations clients
- **Image** : Images des véhicules (relation Many-to-One)

### Migrations

```bash
# Créer une nouvelle migration
docker-compose exec php php bin/console make:migration

# Exécuter les migrations
docker-compose exec php php bin/console doctrine:migrations:migrate

# Voir l'état des migrations
docker-compose exec php php bin/console doctrine:migrations:status
```

---

## 🎨 Personnalisation

### Ajouter une Nouvelle Fonctionnalité

```bash
# Créer un nouveau contrôleur
docker-compose exec php php bin/console make:controller NomController

# Créer une nouvelle entité
docker-compose exec php php bin/console make:entity NomEntity

# Créer un nouveau formulaire
docker-compose exec php php bin/console make:form NomFormType
```

### Vider le Cache

```bash
docker-compose exec php php bin/console cache:clear
```

---

## 📸 Screenshots

### Page d'Accueil
![Home Page](screenshots/home.png)

### Catalogue de Véhicules
![Catalogue](screenshots/catalogue.png)

### Comparaison de Véhicules
![Compare](screenshots/compare.png)

### Dashboard Administrateur
![Admin Dashboard](screenshots/admin.png)

### Chatbot
![Chatbot](screenshots/chatbot.png)

---

## 🐛 Dépannage

### Port 8080 déjà utilisé

```bash
# Arrêter le processus utilisant le port
# Windows PowerShell
Get-Process -Id (Get-NetTCPConnection -LocalPort 8080).OwningProcess | Stop-Process -Force

# Ou changer le port dans docker-compose.yaml
ports:
  - "9090:80"  # Utiliser 9090 au lieu de 8080
```

### Erreur de connexion à la base de données

```bash
# Vérifier que PostgreSQL est démarré
docker-compose ps

# Recréer les conteneurs
docker-compose down -v
docker-compose up -d
```

### Tests qui échouent

```bash
# Recréer la base de données de test
docker-compose exec php php bin/console doctrine:database:drop --force --env=test
docker-compose exec php php bin/console doctrine:database:create --env=test
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test
```

---

## 📚 Documentation Complémentaire

- [Guide d'Installation Complet](INSTALL_GUIDE.md)
- [Guide DevOps](README_DEVOPS.md)
- [Rapport DevOps LaTeX](rapport_devops_final.tex)
- [Checklist Screenshots](CHECKLIST_SCREENSHOTS.md)
- [Guide de Démarrage Rapide](QUICK_START.md)

---

## 📝 Rapport DevOps

Un rapport LaTeX complet est disponible : `rapport_devops_final.tex`

### Compiler le Rapport PDF

```bash
# Windows PowerShell
.\compile-latex.ps1

# Ou manuellement avec pdflatex
pdflatex rapport_devops_final.tex
pdflatex rapport_devops_final.tex  # 2 fois pour la table des matières
```

---

## 🤝 Contribution

Ce projet est un projet académique. Pour toute suggestion ou amélioration :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/amelioration`)
3. Commit les changements (`git commit -m 'Ajout amélioration'`)
4. Push vers la branche (`git push origin feature/amelioration`)
5. Ouvrir une Pull Request

---

## 👨‍💻 Auteur

**Ahmed**
- GitLab : [@ahmedikenjatoun](https://gitlab.com/ahmedikenjatoun)
- GitHub : [@kenjiahmed](https://github.com/kenjiahmed)
- Projet GitLab : [Rent Cars Project](https://gitlab.com/ahmedikenjatoun/rentcars_project)

---

## 📄 Licence

Ce projet est développé dans un cadre académique pour démontrer les compétences en DevOps, Symfony et Docker.

---

## 🙏 Remerciements

- Framework Symfony et sa communauté
- Docker pour la containerisation
- GitLab pour le CI/CD
- PostgreSQL pour la base de données
- Tous les contributeurs open-source

---

## 📞 Support

Pour toute question ou problème :

1. Consulter la [documentation](README_DEVOPS.md)
2. Vérifier les [issues existantes](https://gitlab.com/ahmedikenjatoun/rentcars_project/-/issues)
3. Créer une [nouvelle issue](https://gitlab.com/ahmedikenjatoun/rentcars_project/-/issues/new)

---

<div align="center">

**⭐ Si ce projet vous a aidé, n'hésitez pas à mettre une étoile ! ⭐**

**Made with ❤️ by Ahmed | DevOps 2026**

</div>

