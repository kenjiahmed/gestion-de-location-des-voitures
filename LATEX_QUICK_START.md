# RAPPORT LATEX - GUIDE RAPIDE

## FICHIERS CREES

1. **rapport_devops.tex** - Rapport LaTeX professionnel
2. **LATEX_README.md** - Documentation complete
3. **compile-latex.ps1** - Script de compilation automatique

## METHODES DE COMPILATION

### METHODE 1 : Script Automatique (RECOMMANDE)

```powershell
.\compile-latex.ps1
```

**Ce que fait le script :**
- Verifie le fichier LaTeX
- Verifie les 14 captures d'ecran
- Compile le rapport (3 passes)
- Nettoie les fichiers temporaires
- Ouvre le PDF automatiquement

### METHODE 2 : Overleaf en Ligne (PLUS SIMPLE)

**Si vous n'avez pas LaTeX installe :**

1. Aller sur https://www.overleaf.com
2. Creer un compte gratuit
3. New Project > Upload Project
4. Uploader rapport_devops.tex + dossier screenshots/
5. Cliquer sur "Recompile"
6. Telecharger le PDF

**AVANTAGES :**
- Pas d'installation
- Compilation en ligne
- Preview en temps reel
- Gratuit

### METHODE 3 : Ligne de Commande

```powershell
pdflatex rapport_devops.tex
pdflatex rapport_devops.tex
pdflatex rapport_devops.tex
start rapport_devops.pdf
```

## PREREQUIS (Methode 1 ou 3)

**Installer MiKTeX :**
1. Telecharger : https://miktex.org/download
2. Installer avec options par defaut
3. Accepter installation auto des packages

## PERSONNALISATION

Modifier dans **rapport_devops.tex** avant compilation :

- Ligne 2 : `[VOTRE NOM]`
- Ligne 77 : `[VOTRE NOM]`
- Ligne 557 : `[VOTRE NOM]`
- Ligne 558 : `[votre.email@example.com]`

## CAPTURES D'ECRAN

Le rapport attend 14 captures dans `screenshots/` :

```
01_structure_projet.png   - Structure projet
02_dockerfile.png         - Contenu Dockerfile
03_docker_compose.png     - docker-compose.yml
04_docker_ps.png          - Containers actifs
05_app_running.png        - App sur localhost
06_phpunit_results.png    - Resultats tests
07_tests_structure.png    - Structure tests/
08_gitlab_ci_file.png     - .gitlab-ci.yml
09_gitlab_variables.png   - Variables CI/CD
10_pipeline_overview.png  - Pipeline complet
11_job_tests.png          - Job tests
12_job_build.png          - Job build
13_dockerhub_image.png    - Docker Hub
14_docker_pull.png        - docker pull
```

## WORKFLOW COMPLET

```powershell
# 1. Prendre les captures
.\capture-helper.ps1

# 2. Personnaliser le rapport
notepad rapport_devops.tex

# 3. Compiler
.\compile-latex.ps1

# 4. Verifier le PDF
# (s'ouvre automatiquement)
```

## RESULTAT

**rapport_devops.pdf** (~20-25 pages) avec :
- Page de garde professionnelle
- Table des matieres cliquable
- 7 sections detaillees
- 14 captures d'ecran integrees
- Code source formate
- Diagrammes et tableaux
- Design moderne et colore

## COMPARAISON

| Format | Avantages | Inconvenients |
|--------|-----------|---------------|
| **HTML** | Facile, rapide, pas d'installation | Qualite moyenne |
| **LaTeX** | Qualite professionnelle superieure | Necessite installation/Overleaf |

**LES DEUX SONT DISPONIBLES !**

Choisissez selon vos preferences :
- HTML : RAPPORT_DEVOPS.html
- LaTeX : rapport_devops.tex

## AIDE

**Documentation complete :** LATEX_README.md

**Probleme de compilation ?**
- Utiliser Overleaf en ligne (plus simple)
- Lire LATEX_README.md section Depannage

## TIMELINE

- **Overleaf** : 10 minutes
- **MiKTeX installe** : 5 minutes
- **Installation MiKTeX** : 20 minutes (premiere fois)

## C'EST PRET !

Lancez : `.\compile-latex.ps1`

Bonne chance !

