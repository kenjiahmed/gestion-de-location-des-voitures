# 🚀 GUIDE DE DEMARRAGE RAPIDE - SOLUTION AU PROBLEME DE PORT

## ✅ BUILD DOCKER REUSSI !

Le build Docker a réussi ! Toutes les dépendances sont installées correctement.

## ⚠️ PROBLEME : Port 8080 déjà utilisé

**Erreur** :
```
Bind for 0.0.0.0:8080 failed: port is already allocated
```

## 🔧 SOLUTIONS RAPIDES

### Solution 1 : Changer le port (RECOMMANDE)

Modifiez le fichier `compose.yaml` ligne 27 :

**Avant** :
```yaml
ports:
  - "8080:80"
```

**Après** :
```yaml
ports:
  - "8081:80"  # Utilisez le port 8081 au lieu de 8080
```

**Ensuite** :
```powershell
docker-compose up -d
```

**Accès** : http://localhost:8081

### Solution 2 : Libérer le port 8080

Trouvez le processus qui utilise le port 8080 :

```powershell
netstat -ano | findstr :8080
```

Résultat exemple :
```
TCP    0.0.0.0:8080    0.0.0.0:0    LISTENING    1234
```

Arrêtez le processus (remplacez 1234 par le PID trouvé) :

```powershell
taskkill /PID 1234 /F
```

Puis redémarrez :

```powershell
docker-compose up -d
```

### Solution 3 : Arrêter les anciens conteneurs

Parfois, un ancien conteneur bloque le port :

```powershell
# Arrêter tous les conteneurs Docker
docker stop $(docker ps -aq)

# Supprimer tous les conteneurs arrêtés
docker rm $(docker ps -aq)

# Redémarrer
docker-compose up -d
```

## 📝 COMMANDES COMPLETES POUR DEMARRER

### Méthode manuelle (étape par étape)

```powershell
# 1. Arrêter les conteneurs existants
docker-compose down

# 2. Démarrer les conteneurs
docker-compose up -d

# 3. Attendre 15 secondes
Start-Sleep -Seconds 15

# 4. Vérifier le statut
docker-compose ps

# 5. Installer les dépendances
docker-compose exec php composer install

# 6. Créer la base de données
docker-compose exec php php bin/console doctrine:database:create --if-not-exists

# 7. Exécuter les migrations
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction

# 8. Charger les fixtures
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction

# 9. Vérifier que tout fonctionne
docker-compose ps
```

**Accès** : http://localhost:8080 (ou 8081 si vous avez changé le port)

## 🔍 VERIFICATION

### Vérifier que les 3 conteneurs sont UP

```powershell
docker-compose ps
```

**Résultat attendu** :
```
NAME              STATUS
rent_cars_php     Up
rent_cars_nginx   Up
rent_cars_db      Up (healthy)
```

### Vérifier les logs

```powershell
# Tous les logs
docker-compose logs

# Logs d'un service spécifique
docker-compose logs nginx
docker-compose logs php
docker-compose logs database
```

### Tester l'application

Ouvrez votre navigateur : **http://localhost:8080** (ou 8081)

Si la page s'affiche, c'est gagné ! 🎉

## ❌ EN CAS D'ECHEC

### Réinitialisation complète

```powershell
# Arrêter et supprimer tout
docker-compose down -v

# Supprimer les images
docker rmi rent_cars-php rent_cars-nginx

# Reconstruire
docker-compose build --no-cache

# Démarrer
docker-compose up -d
```

### Vérifier Docker Desktop

1. Ouvrez Docker Desktop
2. Vérifiez qu'il est bien démarré (icône verte)
3. Allez dans Settings > Resources et assurez-vous d'avoir :
   - Au moins 2 GB de RAM
   - Au moins 20 GB d'espace disque

## 📞 AIDE SUPPLEMENTAIRE

### Commandes de diagnostic

```powershell
# Version Docker
docker --version

# Version Docker Compose
docker-compose --version

# Espaces disque utilisé
docker system df

# Logs détaillés
docker-compose logs -f --tail=100
```

### Ports alternatifs

Si 8080 et 8081 sont occupés, essayez :
- 8082
- 8888
- 3000
- 9000

Modifiez dans `compose.yaml` et redémarrez.

---

## ✅ CHECKLIST FINALE

- [ ] Docker Desktop est démarré
- [ ] Port 8080 (ou autre) est libre
- [ ] `docker-compose ps` montre 3 conteneurs UP
- [ ] http://localhost:8080 affiche la page d'accueil
- [ ] Les migrations sont appliquées
- [ ] Les fixtures sont chargées

---

**Date** : 2026-01-05  
**Statut** : Build Docker réussi, problème de port à résoudre

