# 🚀 COMMENT DEMARRER L'APPLICATION

## EN 3 COMMANDES

```powershell
cd C:\Users\USER\Downloads\ahmed-main\ahmed-main\rent_cars

docker-compose up -d

.\start.ps1
```

**C'EST TOUT ! ✨**

---

## ACCEDER A L'APPLICATION

**URL** : http://localhost:8081

> ⚠️ Le port est **8081** (pas 8080)

---

## VERIFIER QUE CA MARCHE

```powershell
docker-compose ps
```

**Vous devez voir 3 conteneurs "Up"** :
- rent_cars_php
- rent_cars_nginx  
- rent_cars_db

---

## EN CAS DE PROBLEME

```powershell
# Tout arreter
docker-compose down

# Tout redemarrer
docker-compose up -d

# Attendre 15 secondes
Start-Sleep -Seconds 15

# Installer les dependances
docker-compose exec php composer install

# Creer la BDD
docker-compose exec php php bin/console doctrine:database:create --if-not-exists

# Migrations
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# Fixtures
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

---

## TESTS

```powershell
docker-compose exec php php bin/phpunit
```

---

## FICHIERS IMPORTANTS

- `FINAL_STATUS.md` - Résumé complet du projet
- `PORT_FIX.md` - Solution au problème de port
- `SCRIPT_FIX.md` - Corrections techniques
- `README.md` - Documentation complète
- `DEVOPS_REPORT_GUIDE.md` - Plan du rapport académique

---

**PORT** : 8081  
**STATUT** : ✅ Prêt  
**BUILD DOCKER** : ✅ Réussi

