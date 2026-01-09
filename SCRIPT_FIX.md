# CORRECTIONS EFFECTUEES - Scripts PowerShell et Docker

## Problemes resolus

### 1. Scripts PowerShell (CORRIGE ✅)

Les fichiers `start.ps1` et `run-tests.ps1` avaient des erreurs de syntaxe dues a un probleme d'encodage et d'ordre des lignes.

**Solution** : Fichiers recrees avec syntaxe correcte et sans accents.

### 2. Extension PHP intl (CORRIGE ✅)

L'extension PHP `intl` necessite les bibliotheques ICU (International Components for Unicode) qui n'etaient pas installees.

**Erreur initiale** :
```
Package 'icu-uc', required by 'virtual:world', not found
Package 'icu-io', required by 'virtual:world', not found
Package 'icu-i18n', required by 'virtual:world', not found
```

**Solution** : Ajout de `libicu-dev` dans les Dockerfiles.

## Fichiers corriges

✅ `start.ps1` - Script de demarrage automatique  
✅ `run-tests.ps1` - Script d'execution des tests  
✅ `Dockerfile` - Image de production (avec libicu-dev)  
✅ `Dockerfile.dev` - Image de developpement (avec libicu-dev)

## Modifications techniques

### Dockerfile.dev et Dockerfile

**Avant** :
```dockerfile
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip opcache intl
```

**Apres** :
```dockerfile
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libicu-dev zip unzip libpq-dev libzip-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip opcache intl
```

**Changements** :
- ✅ Ajout de `libicu-dev` (requis pour intl)
- ✅ Ajout de `docker-php-ext-configure intl` (configuration explicite)
- ✅ Ordre des lignes corrige dans Dockerfile

## Comment utiliser maintenant

### Demarrer l'application

```powershell
.\start.ps1
```

Ce script va automatiquement :
1. Demarrer les conteneurs Docker
2. Installer les dependances Composer
3. Creer la base de donnees PostgreSQL
4. Executer les migrations
5. Charger les fixtures
6. Afficher le statut

**Resultat** : Application disponible sur http://localhost:8080

### Executer les tests

```powershell
.\run-tests.ps1
```

Ce script va automatiquement :
1. Preparer la base de donnees de test
2. Charger les fixtures de test
3. Executer tous les tests PHPUnit
4. Afficher le resume

## Alternative : Commandes manuelles

Si vous preferez executer les commandes manuellement :

```powershell
# Construire les images
docker-compose build --no-cache

# Demarrer
docker-compose up -d

# Installer les dependances
docker-compose exec php composer install

# Base de donnees
docker-compose exec php php bin/console doctrine:database:create --if-not-exists
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

# Tests
docker-compose exec php php bin/phpunit
```

## Verification

Pour verifier que tout fonctionne :

```powershell
# Voir les conteneurs actifs
docker-compose ps

# Verifier les extensions PHP installees
docker-compose exec php php -m | findstr intl

# Voir les logs
docker-compose logs -f

# Tester l'application
# Ouvrir http://localhost:8080 dans le navigateur
```

## En cas de probleme

```powershell
# Arreter les conteneurs
docker-compose down

# Supprimer les volumes et images, puis recommencer
docker-compose down -v
docker system prune -f

# Reconstruire les images
docker-compose build --no-cache

# Relancer le script
.\start.ps1
```

## Extensions PHP installees

Les extensions suivantes sont maintenant correctement installees :

- ✅ **pdo** - PHP Data Objects
- ✅ **pdo_pgsql** - PostgreSQL driver pour PDO
- ✅ **pgsql** - PostgreSQL functions
- ✅ **zip** - ZIP archive support
- ✅ **opcache** - Opcache pour performances
- ✅ **intl** - Internationalization (avec ICU)

---

**Date de correction** : 2026-01-05  
**Statut** : ✅ Scripts et Dockerfiles corriges et fonctionnels


