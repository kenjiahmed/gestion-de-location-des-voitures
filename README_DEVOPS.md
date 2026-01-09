# 🚗 Rent Cars - Application de Location de Voitures

![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Symfony](https://img.shields.io/badge/Symfony-7-black)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue)
![Docker](https://img.shields.io/badge/Docker-✓-blue)

Application complète de location de voitures développée avec Symfony 7, containerisée avec Docker et intégrée dans un pipeline CI/CD GitLab.

## 📋 Table des matières

- [Fonctionnalités](#-fonctionnalités)
- [Technologies](#-technologies)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Utilisation](#-utilisation)
- [Tests](#-tests)
- [CI/CD](#-cicd)
- [Docker Hub](#-docker-hub)
- [Structure du projet](#-structure-du-projet)
- [Documentation](#-documentation)

## ✨ Fonctionnalités

### Pour les utilisateurs
- 🏠 **Page d'accueil** moderne et responsive
- 🚙 **Catalogue de véhicules** avec filtres et pagination
- 🔍 **Recherche avancée** par marque, catégorie, prix
- 📊 **Comparaison** de véhicules côte à côte
- 📅 **Système de réservation** avec calcul automatique du prix
- 👤 **Espace client** avec historique des réservations
- 🌓 **Mode sombre/clair**

### Pour les administrateurs
- 📊 **Tableau de bord** avec statistiques
- ➕ **Gestion CRUD** complète des véhicules
- 🏷️ **Gestion des marques et catégories**
- 📝 **Gestion des réservations**
- 👥 **Gestion des utilisateurs**
- 🖼️ **Upload d'images** pour les véhicules

## 🛠 Technologies

### Backend
- **PHP 8.3** - Langage serveur
- **Symfony 7** - Framework MVC
- **Doctrine ORM** - Mapping objet-relationnel
- **PostgreSQL 15** - Base de données
- **Twig** - Moteur de templates

### Frontend
- **HTML5/CSS3** - Structure et style
- **JavaScript** - Interactivité
- **Bootstrap-inspired** - Design moderne
- **Mode Dark/Light** - Thème adaptatif

### DevOps
- **Docker** - Containerisation
- **Docker Compose** - Orchestration multi-conteneurs
- **GitLab CI/CD** - Intégration et déploiement continus
- **PHPUnit** - Tests automatisés
- **Nginx** - Serveur web

## 📦 Prérequis

- Docker Desktop 20.10+
- Docker Compose 2.0+
- Git

OU

- PHP 8.3+
- Composer 2.x
- PostgreSQL 15+

## 🚀 Installation

### Méthode 1 : Avec Docker (recommandé)

```bash
# 1. Cloner le projet
git clone https://gitlab.com/votre-username/rent_cars.git
cd rent_cars

# 2. Démarrer les conteneurs
docker-compose up -d

# 3. Installer les dépendances
docker-compose exec php composer install

# 4. Créer la base de données et charger les données
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

# 5. Accéder à l'application
# http://localhost:8081
```

### Méthode 2 : Installation locale

```bash
# 1. Cloner et installer les dépendances
git clone https://gitlab.com/votre-username/rent_cars.git
cd rent_cars
composer install

# 2. Configurer la base de données
# Modifier DATABASE_URL dans .env

# 3. Créer la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

# 4. Lancer le serveur Symfony
symfony server:start
```

## 💻 Utilisation

### Comptes de test

**Administrateur :**
- Email: `admin@rentcars.com`
- Mot de passe: `admin123`

**Utilisateur :**
- Email: `user@rentcars.com`
- Mot de passe: `user123`

### URLs principales

- **Accueil** : http://localhost:8081/
- **Catalogue** : http://localhost:8081/catalogue
- **Admin** : http://localhost:8081/admin
- **Connexion** : http://localhost:8081/login

## 🧪 Tests

### Lancer tous les tests

```bash
# Avec Docker
docker-compose exec php php bin/phpunit

# En local
php bin/phpunit
```

### Tests par catégorie

```bash
# Tests unitaires
docker-compose exec php php bin/phpunit tests/Unit

# Tests d'intégration
docker-compose exec php php bin/phpunit tests/Integration

# Tests fonctionnels
docker-compose exec php php bin/phpunit tests/Functional
```

### Couverture de code

```bash
docker-compose exec php php bin/phpunit --coverage-html coverage
```

## 🔄 CI/CD

Le projet utilise GitLab CI/CD avec 4 stages :

### 1. Install
- Installation des dépendances Composer
- Cache des vendors
- Artifacts sauvegardés

### 2. Test
- **unit_tests** : Tests unitaires avec PostgreSQL
- **integration_tests** : Tests d'intégration avec fixtures
- **code_quality** : Analyse statique du code

### 3. Build
- Construction de l'image Docker
- Tag avec commit SHA
- Disponible pour review

### 4. Docker
- Login à Docker Hub
- Push de l'image avec tags
- Déclenchement manuel sur main uniquement

### Configuration GitLab CI

Variables à définir dans **Settings > CI/CD > Variables** :

```
DOCKER_HUB_USERNAME : votre_username
DOCKER_HUB_PASSWORD : votre_password (masked)
```

## 🐳 Docker Hub

L'image est disponible sur Docker Hub :

```bash
# Pull l'image
docker pull yourusername/rent_cars:latest

# Lancer le conteneur
docker run -d -p 8081:80 \
  -e DATABASE_URL="postgresql://user:pass@host:5432/db" \
  yourusername/rent_cars:latest
```

## 📁 Structure du projet

```
rent_cars/
├── bin/                    # Scripts Symfony
├── config/                 # Configuration Symfony
│   ├── packages/          # Configuration des bundles
│   └── routes/            # Définition des routes
├── docker/                 # Configuration Docker
│   ├── nginx/             # Config Nginx
│   └── php/               # Config PHP
├── migrations/             # Migrations Doctrine
├── public/                 # Point d'entrée web
│   ├── css/               # Styles CSS
│   ├── js/                # Scripts JavaScript
│   └── images/            # Images publiques
├── src/                    # Code source
│   ├── Controller/        # Contrôleurs
│   ├── Entity/            # Entités Doctrine
│   ├── Form/              # Formulaires Symfony
│   ├── Repository/        # Repositories Doctrine
│   └── DataFixtures/      # Données de test
├── templates/              # Templates Twig
│   ├── admin/             # Templates admin
│   ├── catalogue/         # Templates catalogue
│   ├── home/              # Templates accueil
│   └── base.html.twig     # Template de base
├── tests/                  # Tests automatisés
│   ├── Unit/              # Tests unitaires
│   ├── Integration/       # Tests d'intégration
│   └── Functional/        # Tests fonctionnels
├── .gitlab-ci.yml          # Pipeline CI/CD
├── docker-compose.yml      # Orchestration Docker
├── Dockerfile              # Image Docker production
└── Dockerfile.dev          # Image Docker développement
```

## 📚 Documentation

- [DEVOPS_COMPLETE_GUIDE.md](./DEVOPS_COMPLETE_GUIDE.md) - Guide complet DevOps et rapport académique
- [START_HERE.md](./START_HERE.md) - Démarrage rapide
- [FINAL_STATUS.md](./FINAL_STATUS.md) - État final du projet

## 🏗 Architecture

### Architecture Applicative

```
┌─────────────┐
│  Navigateur │
└──────┬──────┘
       │ HTTP
┌──────▼──────┐
│    Nginx    │ Port 8081
└──────┬──────┘
       │ FastCGI
┌──────▼──────┐
│  PHP 8.3    │
│  + Symfony  │
└──────┬──────┘
       │ PDO
┌──────▼──────┐
│ PostgreSQL  │
│     15      │
└─────────────┘
```

### Conteneurs Docker

```yaml
services:
  nginx:    # Serveur web (port 8081)
  php:      # PHP-FPM 8.3 + Symfony
  postgres: # Base de données PostgreSQL 15
```

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence MIT.

## 👤 Auteur

**Votre Nom**
- GitLab: [@votre-username](https://gitlab.com/votre-username)
- Email: votre.email@example.com

## 🙏 Remerciements

- Symfony Community
- Docker Community
- PostgreSQL Team
- Tous les contributeurs open source

---

**Made with ❤️ and ☕ for academic purposes**

