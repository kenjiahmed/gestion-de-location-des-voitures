# RAPPORT LATEX - GUIDE DE COMPILATION

## FICHIER CREE

**rapport_devops.tex** - Rapport LaTeX professionnel de 20+ pages

## PREREQUIS

Pour compiler le rapport LaTeX, vous avez besoin d'une distribution LaTeX installée.

### Windows - MiKTeX (RECOMMANDE)

1. **Telecharger MiKTeX** : https://miktex.org/download
2. **Installer MiKTeX** avec les options par defaut
3. **Accepter l'installation automatique** des packages manquants

### Alternative - TeX Live

1. **Telecharger TeX Live** : https://www.tug.org/texlive/
2. **Installer TeX Live** (installation complete ~4GB)

### Alternative en ligne - Overleaf (PLUS SIMPLE)

1. **Aller sur** : https://www.overleaf.com
2. **Creer un compte gratuit**
3. **Nouveau projet** > Upload Project
4. **Uploader** rapport_devops.tex + dossier screenshots/
5. **Compiler** en cliquant sur "Recompile"

## METHODE 1 : COMPILATION AUTOMATIQUE (Script PowerShell)

```powershell
.\compile-latex.ps1
```

Le script va :
- Verifier que les captures sont presentes
- Compiler le LaTeX automatiquement
- Generer le PDF : rapport_devops.pdf
- Ouvrir le PDF automatiquement

## METHODE 2 : COMPILATION MANUELLE

### Avec pdflatex (ligne de commande)

```powershell
# Compilation (3 passes pour table des matieres)
pdflatex rapport_devops.tex
pdflatex rapport_devops.tex
pdflatex rapport_devops.tex

# Ouvrir le PDF
start rapport_devops.pdf
```

### Avec un editeur LaTeX

**TeXstudio** (recommande) :
1. Telecharger : https://www.texstudio.org
2. Ouvrir rapport_devops.tex
3. Appuyer sur F5 ou cliquer sur "Build & View"

**TeXworks** (inclus avec MiKTeX) :
1. Ouvrir rapport_devops.tex
2. Selectionner "pdfLaTeX" dans le menu deroulant
3. Cliquer sur le bouton vert "Composer"

## STRUCTURE DU RAPPORT

Le rapport LaTeX comprend :

1. **Page de garde** professionnelle avec logo
2. **Table des matieres** interactive
3. **7 sections detaillees** :
   - Introduction
   - Architecture
   - Dockerisation
   - Tests automatises
   - Pipeline CI/CD
   - Deploiement Docker Hub
   - Conclusion
4. **Annexes** avec commandes utiles
5. **14 captures d'ecran** integrees

## EMPLACEMENTS DES CAPTURES

Le rapport attend les captures dans le dossier `screenshots/` :

```
screenshots/
├── 01_structure_projet.png
├── 02_dockerfile.png
├── 03_docker_compose.png
├── 04_docker_ps.png
├── 05_app_running.png
├── 06_phpunit_results.png
├── 07_tests_structure.png
├── 08_gitlab_ci_file.png
├── 09_gitlab_variables.png
├── 10_pipeline_overview.png
├── 11_job_tests.png
├── 12_job_build.png
├── 13_dockerhub_image.png
└── 14_docker_pull.png
```

## PERSONNALISATION AVANT COMPILATION

Modifier dans **rapport_devops.tex** :

1. **Ligne 2** : Remplacer `[VOTRE NOM]` par votre nom
2. **Ligne 77** : Remplacer `[VOTRE NOM]` par votre nom
3. **Ligne 557** : Remplacer `[VOTRE NOM]` par votre nom
4. **Ligne 558** : Remplacer `[votre.email@example.com]` par votre email

## PACKAGES LATEX UTILISES

Le rapport utilise les packages suivants (installes automatiquement) :

- geometry : Marges et mise en page
- graphicx : Insertion d'images
- hyperref : Liens hypertexte
- xcolor : Couleurs personnalisees
- fancyhdr : En-tetes et pieds de page
- titlesec : Mise en forme des titres
- listings : Code source formate
- tcolorbox : Boites colorees
- tikz : Diagrammes et schemas
- booktabs : Tableaux professionnels

## RESULTATS ATTENDUS

Apres compilation, vous obtenez :

- **rapport_devops.pdf** (~20-25 pages)
- **Qualite professionnelle** avec mise en page soignee
- **Table des matieres cliquable** avec navigation
- **Couleurs et graphiques** integres
- **Code source formate** avec coloration syntaxique
- **Captures d'ecran** en haute qualite

## AVANTAGES DU LATEX

- **Qualite professionnelle** superieure au HTML/Word
- **Typographie parfaite** (formules, tableaux, code)
- **Navigation automatique** (table des matieres cliquable)
- **Numerotation automatique** (sections, figures, tableaux)
- **References croisees** automatiques
- **Format PDF universel** lisible partout

## DEPANNAGE

### Erreur : pdflatex non trouve

**Solution** : Installer MiKTeX ou TeX Live

### Erreur : Package manquant

**Solution** : MiKTeX proposera l'installation automatique, accepter

### Images non trouvees

**Solution** : Verifier que le dossier screenshots/ existe avec les 14 images

### Compilation longue

**Solution** : Normal pour la 1ere compilation (installation packages)
Les compilations suivantes sont rapides (~10 secondes)

### Erreurs de compilation

**Solution** : Verifier que tous les caracteres speciaux sont echappes
Si probleme, utiliser Overleaf en ligne

## WORKFLOW COMPLET

```powershell
# 1. Prendre les captures d'ecran
.\capture-helper.ps1

# 2. Personnaliser le rapport
notepad rapport_devops.tex
# Remplacer [VOTRE NOM] et [votre.email@example.com]

# 3. Compiler le LaTeX
.\compile-latex.ps1

# 4. Verifier le PDF
start rapport_devops.pdf
```

## ALTERNATIVE : OVERLEAF EN LIGNE

Si vous n'avez pas LaTeX installe :

1. **Aller sur** https://www.overleaf.com
2. **Creer un compte** (gratuit)
3. **New Project** > Upload Project
4. **Uploader** :
   - rapport_devops.tex
   - Tout le dossier screenshots/ avec les 14 images
5. **Recompile** (bouton vert en haut)
6. **Download PDF** (icone de telechargement)

**AVANTAGES OVERLEAF** :
- Pas d'installation necessaire
- Compilation dans le cloud
- Preview en temps reel
- Collaboration possible
- Sauvegarde automatique

## COMPARAISON HTML vs LATEX

| Critere | HTML | LaTeX |
|---------|------|-------|
| Installation | Navigateur (natif) | MiKTeX/TeX Live |
| Qualite typo | Bonne | Excellente |
| Formules math | Difficile | Facile |
| Code source | Moyen | Excellent |
| Navigation | Moyenne | Excellente |
| Professionnalisme | Bon | Superieur |
| Facilite | Facile | Moyen |

## RECOMMENDATION

**Pour une presentation academique** : LaTeX est prefere
**Pour rapidite** : HTML convient aussi

Les deux versions sont disponibles :
- RAPPORT_DEVOPS.html (HTML)
- rapport_devops.tex (LaTeX)

Choisissez selon vos preferences et contraintes !

## TIMELINE

- **Avec MiKTeX installe** : 5 minutes
- **Sans LaTeX** (Overleaf) : 10 minutes
- **Installation MiKTeX** : 20 minutes premiere fois

## AIDE SUPPLEMENTAIRE

- **Overleaf Tutoriel** : https://www.overleaf.com/learn
- **LaTeX Wikibook** : https://en.wikibooks.org/wiki/LaTeX
- **MiKTeX Doc** : https://docs.miktex.org

## TOUT EST PRET !

Vous avez maintenant :
1. ✅ rapport_devops.tex (fichier LaTeX)
2. ✅ screenshots/ (dossier pour images)
3. ✅ LATEX_README.md (ce guide)
4. ✅ compile-latex.ps1 (script auto)

**Prochaine etape** : Compiler avec `.\compile-latex.ps1`

Bonne chance pour votre presentation !

