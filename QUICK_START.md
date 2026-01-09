# 🚀 Guide de Démarrage Rapide - Rent Cars

## Configuration GitLab CI/CD

### 1. Variables à configurer dans GitLab

Allez dans **Settings > CI/CD > Variables** et ajoutez :

| Variable | Valeur | Masked | Protected |
|----------|--------|--------|-----------|
| `DOCKER_HUB_USERNAME` | Votre nom d'utilisateur Docker Hub | ✅ | ❌ |
| `DOCKER_HUB_PASSWORD` | Votre mot de passe Docker Hub | ✅ | ✅ |

### 2. Pousser le code sur GitLab

```bash
# Initialiser le dépôt Git (si pas déjà fait)
git init

# Ajouter l'origine GitLab
git remote add origin https://gitlab.com/<username>/<project>.git

# Ajouter tous les fichiers
git add .

# Commit initial
git commit -m "feat: Dockerisation complète avec CI/CD GitLab"

# Pousser sur la branche main
git push -u origin main
```

### 3. Vérifier le pipeline

1. Allez sur GitLab dans **CI/CD > Pipelines**
2. Vous devriez voir 4 stages : `install` → `test` → `build` → `docker`
3. Attendez que tous les stages soient verts ✅

### 4. Vérifier l'image sur Docker Hub

1. Allez sur https://hub.docker.com/r/<username>/rent_cars
2. Vous devriez voir les tags : `latest`, `main`, et `<commit-sha>`

---

## Démarrage Local

### Méthode 1 : Script PowerShell (Recommandé)

```powershell
.\start.ps1
```

### Méthode 2 : Commandes manuelles

```bash
# 1. Démarrer les conteneurs
docker-compose up -d --build

# 2. Installer les dépendances
docker-compose exec php composer install

# 3. Créer la base de données
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# 4. Charger les données de test
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

# 5. Accéder à l'application
```

**URL** : http://localhost:8080

---

## Exécution des Tests

### Méthode 1 : Script PowerShell (Recommandé)

```powershell
.\run-tests.ps1
```

### Méthode 2 : Commandes manuelles

```bash
# Tests unitaires
docker-compose exec php php bin/phpunit tests/Unit

# Tests d'intégration
docker-compose exec php php bin/phpunit tests/Integration

# Tests fonctionnels
docker-compose exec php php bin/phpunit tests/Functional

# Tous les tests
docker-compose exec php php bin/phpunit
```

---

## Captures d'écran pour le rapport

### Obligatoires

1. **Docker Compose**
   - `docker-compose ps` - Statut des conteneurs
   - `docker-compose logs php` - Logs PHP-FPM

2. **Application**
   - http://localhost:8080 - Page d'accueil
   - http://localhost:8080/catalogue - Liste des véhicules

3. **Tests**
   - Résultat de `docker-compose exec php php bin/phpunit`

4. **GitLab Pipeline**
   - Vue d'ensemble du pipeline (4 stages)
   - Détails du job `test:unit`
   - Détails du job `deploy:dockerhub`

5. **Docker Hub**
   - Page du repository avec les tags

### Optionnelles

- Couverture de code
- Logs détaillés des jobs CI/CD
- Commande `docker images` montrant l'image locale

---

## Commandes Utiles

### Docker

```bash
# Voir les conteneurs
docker-compose ps

# Voir les logs
docker-compose logs -f

# Arrêter les conteneurs
docker-compose down

# Supprimer les volumes (⚠️ Supprime la BDD)
docker-compose down -v

# Reconstruire les images
docker-compose up -d --build --force-recreate
```

### Symfony

```bash
# Accéder au conteneur PHP
docker-compose exec php bash

# Créer un contrôleur
docker-compose exec php php bin/console make:controller

# Créer une entité
docker-compose exec php php bin/console make:entity

# Créer une migration
docker-compose exec php php bin/console make:migration

# Effacer le cache
docker-compose exec php php bin/console cache:clear
```

### Base de données

```bash
# Accéder à PostgreSQL
docker-compose exec database psql -U app -d app

# Lister les tables
docker-compose exec database psql -U app -d app -c "\dt"

# Dump de la base de données
docker-compose exec database pg_dump -U app app > backup.sql
```

---

## Résolution de problèmes

### Erreur "Port 8080 déjà utilisé"

```bash
# Modifier le port dans compose.yaml
# ports:
#   - "8081:80"  # Au lieu de 8080:80
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
# Recréer la base de données de test
docker-compose exec php php bin/console doctrine:database:drop --force --env=test
docker-compose exec php php bin/console doctrine:database:create --env=test
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --env=test
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction --env=test
```

### Le pipeline GitLab échoue

1. Vérifier les variables CI/CD (DOCKER_HUB_USERNAME et DOCKER_HUB_PASSWORD)
2. Vérifier les logs du job qui échoue
3. Tester localement avec Docker

---

## Architecture Technique

### Services Docker

```
┌─────────────────┐
│   Nginx :8080   │  → Serveur web
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  PHP-FPM :9000  │  → Application Symfony
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ PostgreSQL:5432 │  → Base de données
└─────────────────┘
```

### Pipeline CI/CD

```
┌──────────┐    ┌──────────┐    ┌──────────┐    ┌──────────┐
│ Install  │ -> │   Test   │ -> │  Build   │ -> │  Docker  │
│ Composer │    │ PHPUnit  │    │  Image   │    │   Push   │
└──────────┘    └──────────┘    └──────────┘    └──────────┘
    ~1min           ~3min           ~2min           ~2min
```

---

## Support

- 📖 Documentation complète : `README.md`
- 📋 Guide du rapport : `DEVOPS_REPORT_GUIDE.md`
- 🐛 Issues : GitLab Issues
- 📧 Contact : Votre équipe de développement

---

**Version** : 1.0.0  
**Dernière mise à jour** : Janvier 2026

