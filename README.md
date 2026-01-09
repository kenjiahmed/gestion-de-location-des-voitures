# Application Rent Cars - Symfony

## 🚀 Démarrage rapide avec Docker

### Prérequis
- Docker Desktop installé
- Docker Compose installé
- Port 8080 disponible

### Installation et démarrage

```bash
# 1. Construire et démarrer les conteneurs
docker-compose up -d --build

# 2. Installer les dépendances
docker-compose exec php composer install

# 3. Créer la base de données et exécuter les migrations
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# 4. Charger les données de test (fixtures)
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

# 5. Accéder à l'application
```

Ouvrir le navigateur : **http://localhost:8080**

---

## 🧪 Tests

### Exécuter tous les tests
```bash
docker-compose exec php php bin/phpunit
```

### Tests par type
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

---

## 🔧 Commandes utiles

### Gestion des conteneurs
```bash
# Démarrer les conteneurs
docker-compose up -d

# Arrêter les conteneurs
docker-compose down

# Voir les logs
docker-compose logs -f

# Logs d'un service spécifique
docker-compose logs -f php
docker-compose logs -f nginx
docker-compose logs -f database
```

### Symfony dans Docker
```bash
# Accéder au conteneur PHP
docker-compose exec php bash

# Effacer le cache
docker-compose exec php php bin/console cache:clear

# Créer une migration
docker-compose exec php php bin/console make:migration

# Créer un contrôleur
docker-compose exec php php bin/console make:controller
```

### Base de données
```bash
# Accéder à PostgreSQL
docker-compose exec database psql -U app -d app

# Dump de la base de données
docker-compose exec database pg_dump -U app app > backup.sql

# Restaurer une base de données
docker-compose exec -T database psql -U app app < backup.sql
```

---

## 🔐 Variables d'environnement

Les variables sont définies dans `.env.local` :

```env
POSTGRES_VERSION=16
POSTGRES_DB=app
POSTGRES_USER=app
POSTGRES_PASSWORD=!ChangeMe!
APP_ENV=dev
DATABASE_URL=postgresql://app:!ChangeMe!@database:5432/app?serverVersion=16&charset=utf8
```

---

## 🏗️ Architecture Docker

### Services

1. **PHP-FPM** (port 9000)
   - Image : PHP 8.2 FPM
   - Extensions : PDO, PostgreSQL, Zip, Intl, Opcache
   - Xdebug activé en dev

2. **Nginx** (port 8080)
   - Image : Nginx Alpine
   - Proxy vers PHP-FPM
   - Configuration dans `docker/nginx/default.conf`

3. **PostgreSQL** (port 5432)
   - Image : PostgreSQL 16 Alpine
   - Volume persistant : `database_data`
   - Healthcheck intégré

---

## 🚢 CI/CD avec GitLab

### Configuration

1. **Variables GitLab CI/CD à définir** :
   - `DOCKER_HUB_USERNAME` : Nom d'utilisateur Docker Hub
   - `DOCKER_HUB_PASSWORD` : Mot de passe Docker Hub

2. **Pipeline stages** :
   - `install` : Installation des dépendances
   - `test` : Exécution des tests
   - `build` : Construction de l'image Docker
   - `docker` : Push sur Docker Hub (branche main uniquement)

### Déclenchement du pipeline

```bash
git add .
git commit -m "feat: nouvelle fonctionnalité"
git push origin main
```

---

## 📦 Déploiement sur Docker Hub

L'image Docker est automatiquement publiée sur Docker Hub lors d'un merge sur `main`.

### Récupération de l'image
```bash
docker pull <votre-username>/rent_cars:latest
```

### Exécution de l'image
```bash
docker run -d -p 8080:80 \
  -e DATABASE_URL="postgresql://user:pass@host:5432/db" \
  <votre-username>/rent_cars:latest
```

---

## 🐛 Dépannage

### Les conteneurs ne démarrent pas
```bash
# Vérifier les logs
docker-compose logs

# Reconstruire les images
docker-compose up -d --build --force-recreate
```

### Erreur de connexion à la base de données
```bash
# Vérifier que PostgreSQL est prêt
docker-compose exec database pg_isready -U app

# Recréer la base de données
docker-compose exec php php bin/console doctrine:database:drop --force
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

### Les tests échouent
```bash
# Créer la base de données de test
docker-compose exec php php bin/console doctrine:database:create --env=test

# Exécuter les migrations de test
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test

# Charger les fixtures de test
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction --env=test
```

---

## 📚 Structure du projet

```
rent_cars/
├── docker/                    # Configuration Docker
│   ├── nginx/                # Config Nginx
│   └── php/                  # Config PHP
├── src/                      # Code source Symfony
│   ├── Controller/
│   ├── Entity/
│   ├── Repository/
│   └── Form/
├── tests/                    # Tests
│   ├── Unit/                # Tests unitaires
│   ├── Integration/         # Tests d'intégration
│   └── Functional/          # Tests fonctionnels
├── Dockerfile               # Image Docker production
├── Dockerfile.dev           # Image Docker développement
├── compose.yaml             # Docker Compose
├── .gitlab-ci.yml           # Pipeline CI/CD
└── README.md                # Documentation
```

---

## 👥 Équipe de développement

Projet académique - Symfony 7.3 + Docker + GitLab CI/CD

## 📄 Licence

Propriétaire - Usage académique uniquement

