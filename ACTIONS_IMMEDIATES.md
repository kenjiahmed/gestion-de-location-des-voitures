# 🎯 ACTIONS IMMÉDIATES - PIPELINE GITLAB

## ⏰ À FAIRE MAINTENANT (5 minutes)

---

## ✅ ÉTAPE 1 : VÉRIFIER LE PUSH

```powershell
# Dans PowerShell, vérifier que tout est poussé
cd C:\Users\USER\Downloads\ahmed-main\ahmed-main\rent_cars
git status
git log --oneline -3
```

**Résultat attendu** :
```
✅ "On branch main"
✅ "Your branch is up to date with 'gitlab/main'"
✅ Dernier commit visible : "fix: Correction du pipeline GitLab CI/CD..."
```

---

## ✅ ÉTAPE 2 : OUVRIR GITLAB (2 minutes)

### 2.1 Accéder au Projet

**Ouvrez ce lien** : https://gitlab.com/ahmedikenjatoun/rentcars_project

### 2.2 Vérifier que le Code est Là

Vous devriez voir :
- ✅ Le README affiché
- ✅ Tous vos fichiers
- ✅ Le dernier commit

### 2.3 Aller sur les Pipelines

**Cliquez sur** : CI/CD > Pipelines (dans le menu de gauche)

**OU utilisez ce lien direct** : 
https://gitlab.com/ahmedikenjatoun/rentcars_project/-/pipelines

---

## ✅ ÉTAPE 3 : VÉRIFIER LE PIPELINE (3 minutes)

### 3.1 Que Voir sur la Page Pipelines ?

Vous devriez voir **au moins 1 pipeline** qui :

| État | Que faire ? |
|------|-------------|
| 🔵 **Running** | ✅ Parfait ! Attendez qu'il se termine (5-10 min) |
| ✅ **Passed** | ✅ Excellent ! Passez à l'ÉTAPE 4 |
| ❌ **Failed** | ⚠️ Cliquez dessus pour voir quel stage a échoué |
| ⏸️ **Pending** | ⏰ Attendez 1-2 minutes puis rafraîchissez |

### 3.2 Si le Pipeline est ✅ PASSED

**FÉLICITATIONS !** 🎉

Votre pipeline fonctionne parfaitement !

**Actions** :
1. ✅ Cliquez sur le pipeline pour voir les détails
2. ✅ Prenez des screenshots (voir ÉTAPE 4)
3. ✅ Passez à la configuration Docker Hub (optionnel)

### 3.3 Si le Pipeline est ❌ FAILED

**Ne paniquez pas !** C'est normal, on va corriger.

**Actions** :
1. Cliquez sur le pipeline en échec
2. Identifiez le stage/job en rouge
3. Consultez le fichier `GITLAB_PIPELINE_VERIFICATION.md` section "DÉPANNAGE"
4. OU contactez-moi avec le nom du job qui a échoué

### 3.4 Si le Pipeline est 🔵 RUNNING

**C'est normal !** Le premier build prend du temps.

**Durée estimée** :
- Stage 1 (install) : ~2-3 minutes
- Stage 2 (test) : ~3-5 minutes
- Stage 3 (build) : ~3-5 minutes
- **Total** : ~10-15 minutes

**Actions** :
- ☕ Prenez un café
- 🔄 Rafraîchissez la page toutes les 2 minutes
- 📊 Surveillez l'avancement

---

## ✅ ÉTAPE 4 : PRENDRE LES SCREENSHOTS (5 minutes)

### Une fois que le pipeline est ✅ PASSED

**Screenshot 1 : Vue d'ensemble du pipeline**
1. Sur la page Pipelines, cliquez sur le pipeline réussi
2. Prenez un screenshot montrant les 4 stages en vert
3. Sauvegardez : `screenshots/gitlab/01-pipeline-success.png`

**Screenshot 2 : Stage INSTALL**
1. Cliquez sur le job `install_dependencies`
2. Scrollez jusqu'à voir "Uploading artifacts..."
3. Prenez un screenshot
4. Sauvegardez : `screenshots/gitlab/02-stage-install.png`

**Screenshot 3 : Stage TEST (unit_tests)**
1. Cliquez sur le job `unit_tests`
2. Scrollez jusqu'à voir "OK (X tests, Y assertions)"
3. Prenez un screenshot
4. Sauvegardez : `screenshots/gitlab/03-stage-test-unit.png`

**Screenshot 4 : Stage BUILD**
1. Cliquez sur le job `build_docker_image`
2. Scrollez jusqu'à voir "Successfully built"
3. Prenez un screenshot
4. Sauvegardez : `screenshots/gitlab/04-stage-build.png`

### Comment prendre un screenshot sur Windows

**Méthode 1 (Recommandée)** :
- Appuyez sur **Win + Shift + S**
- Sélectionnez la zone à capturer
- L'image est dans le presse-papier
- Collez dans Paint ou directement dans un dossier

**Méthode 2** :
- Appuyez sur **Win + PrtScn**
- L'image est sauvegardée dans `C:\Users\USER\Pictures\Screenshots`

---

## ✅ ÉTAPE 5 : CONFIGURER DOCKER HUB (OPTIONNEL - 10 minutes)

### Pourquoi le faire ?

- ✅ Compléter le pipeline à 100%
- ✅ Montrer le déploiement continu
- ✅ Impressionner le prof 😎

### Comment le faire ?

**5.1 Créer un compte Docker Hub** (si pas déjà fait)
1. Allez sur https://hub.docker.com
2. Cliquez sur "Sign Up"
3. Créez votre compte (gratuit)
4. Confirmez votre email

**5.2 Créer un Access Token**
1. Connectez-vous sur Docker Hub
2. Cliquez sur votre nom en haut à droite
3. **Account Settings** > **Security**
4. Cliquez sur **New Access Token**
5. Nom : `gitlab-ci-rentcars`
6. Permissions : **Read, Write, Delete**
7. Cliquez sur **Generate**
8. **COPIEZ LE TOKEN** ⚠️ (vous ne pourrez plus le voir !)

**5.3 Ajouter les variables dans GitLab**
1. Sur GitLab : **Settings** > **CI/CD**
2. Trouvez **Variables** > **Expand**
3. Cliquez sur **Add variable**

**Variable 1** :
```
Key: DOCKER_HUB_USERNAME
Value: votre_username_dockerhub
Protect: ✅ Coché
Mask: ❌ Décoché
```

**Variable 2** :
```
Key: DOCKER_HUB_PASSWORD
Value: le_token_copié
Protect: ✅ Coché
Mask: ✅ Coché
```

**5.4 Déclencher le Push Docker Hub**
1. Retournez sur **CI/CD** > **Pipelines**
2. Cliquez sur le dernier pipeline réussi
3. Trouvez le job `push_to_dockerhub` (stage docker)
4. Cliquez sur le bouton **Play** ▶️
5. Le job va pusher l'image vers Docker Hub
6. Vérifiez sur https://hub.docker.com que l'image apparaît

**5.5 Screenshot Docker Hub**
1. Sur Docker Hub, allez sur vos repositories
2. Cliquez sur `rent_cars`
3. Prenez un screenshot montrant l'image
4. Sauvegardez : `screenshots/dockerhub/05-repository.png`

---

## ✅ ÉTAPE 6 : VÉRIFIER LOCALEMENT (5 minutes)

### Tester que l'application fonctionne toujours

```powershell
# Dans PowerShell
cd C:\Users\USER\Downloads\ahmed-main\ahmed-main\rent_cars

# Arrêter les conteneurs existants
docker-compose down

# Démarrer les conteneurs
docker-compose up -d

# Attendre 30 secondes
Start-Sleep -Seconds 30

# Vérifier que tout tourne
docker-compose ps

# Lancer les tests
docker-compose exec php php bin/phpunit

# Ouvrir l'application
start http://localhost:8080
```

**Résultat attendu** :
```
✅ 3 conteneurs running (nginx, php, db)
✅ Tests : OK (10 tests, 28 assertions)
✅ Application accessible sur http://localhost:8080
```

---

## 📋 CHECKLIST RAPIDE

### Avant de Partir

- [ ] Code poussé sur GitLab ✅
- [ ] Pipeline visible sur GitLab
- [ ] Pipeline passe (au moins 3/4 stages)
- [ ] Screenshots pris (minimum 4)
- [ ] Application fonctionne localement

### Optionnel (mais recommandé)

- [ ] Docker Hub configuré
- [ ] Image poussée sur Docker Hub
- [ ] Screenshot Docker Hub pris

---

## 🆘 SI QUELQUE CHOSE NE FONCTIONNE PAS

### Le Pipeline Échoue

**Consultez** : `GITLAB_PIPELINE_VERIFICATION.md` section "DÉPANNAGE"

**Ou rapide** :
1. Cliquez sur le job en échec
2. Lisez les dernières lignes des logs
3. Cherchez le mot "error" ou "failed"
4. Copiez l'erreur et cherchez-la dans les guides

### L'Application Locale ne Marche Plus

```powershell
# Tout arrêter
docker-compose down -v

# Nettoyer
docker system prune -f

# Redémarrer
docker-compose up -d --build

# Réinitialiser la DB
docker-compose exec php php bin/console doctrine:database:drop --force --if-exists
docker-compose exec php php bin/console doctrine:database:create
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec php php bin/console doctrine:fixtures:load --no-interaction
```

### Docker Hub ne Fonctionne Pas

**Vérifiez** :
1. Token copié correctement (sans espaces)
2. Variables bien créées dans GitLab
3. Variable DOCKER_HUB_PASSWORD est bien masquée
4. Token n'a pas expiré sur Docker Hub

---

## 📞 FICHIERS DE RÉFÉRENCE

**Pour plus de détails, consultez** :

| Fichier | Description |
|---------|-------------|
| `GITLAB_PIPELINE_VERIFICATION.md` | Guide complet de vérification + dépannage |
| `GITLAB_CI_CORRECTIONS.md` | Détails des corrections appliquées |
| `GITLAB_PUSH_SUCCESS.md` | Confirmation du push + infos projet |
| `GUIDE_PRESENTATION.md` | Comment préparer la présentation |
| `README_GITLAB.md` | Documentation complète du projet |

---

## 🎯 RÉSUMÉ - CE QU'IL FAUT FAIRE

1. ✅ **Vérifier** que le code est sur GitLab
2. ✅ **Ouvrir** GitLab > CI/CD > Pipelines
3. ✅ **Attendre** que le pipeline se termine (10-15 min)
4. ✅ **Prendre** 4-5 screenshots
5. ⚪ **Configurer** Docker Hub (optionnel)
6. ✅ **Vérifier** l'application localement

---

## ⏱️ TEMPS ESTIMÉ TOTAL

- **Minimum** : 15 minutes (sans Docker Hub)
- **Complet** : 30 minutes (avec Docker Hub)

---

<div align="center">

# 🚀 VOUS ÊTES PRESQUE PRÊT !

## Suivez ces étapes et votre pipeline sera opérationnel

**URL du projet** : https://gitlab.com/ahmedikenjatoun/rentcars_project

**Prochaine étape** : Ouvrir GitLab et vérifier le pipeline ! 🎓

</div>

