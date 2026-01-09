# Script PowerShell pour compiler automatiquement le rapport LaTeX
# Usage: .\compile-latex.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  COMPILATION RAPPORT LATEX            " -ForegroundColor Cyan
Write-Host "  Projet Rent Cars - DevOps            " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Verification de l'existence du fichier LaTeX
if (!(Test-Path "rapport_devops.tex")) {
    Write-Host "ERREUR: Fichier rapport_devops.tex introuvable !" -ForegroundColor Red
    exit 1
}

Write-Host "[1/5] Verification du fichier LaTeX..." -ForegroundColor Yellow
Write-Host "  OK Fichier rapport_devops.tex trouve" -ForegroundColor Green
Write-Host ""

# Verification des captures d'ecran
Write-Host "[2/5] Verification des captures d'ecran..." -ForegroundColor Yellow
$screenshots = @(
    "01_structure_projet.png",
    "02_dockerfile.png",
    "03_docker_compose.png",
    "04_docker_ps.png",
    "05_app_running.png",
    "06_phpunit_results.png",
    "07_tests_structure.png",
    "08_gitlab_ci_file.png",
    "09_gitlab_variables.png",
    "10_pipeline_overview.png",
    "11_job_tests.png",
    "12_job_build.png",
    "13_dockerhub_image.png",
    "14_docker_pull.png"
)

$missing = @()
foreach ($screenshot in $screenshots) {
    $path = "screenshots\$screenshot"
    if (Test-Path $path) {
        Write-Host "  OK $screenshot" -ForegroundColor Green
    } else {
        Write-Host "  MANQUANT $screenshot" -ForegroundColor Red
        $missing += $screenshot
    }
}

Write-Host ""
if ($missing.Count -gt 0) {
    Write-Host "ATTENTION: $($missing.Count) capture(s) manquante(s)" -ForegroundColor Yellow
    Write-Host "Le PDF sera genere mais certaines images seront manquantes." -ForegroundColor Yellow
    Write-Host ""
    $response = Read-Host "Continuer quand meme ? (O/N)"
    if ($response -ne "O" -and $response -ne "o") {
        Write-Host "Compilation annulee." -ForegroundColor Yellow
        exit 0
    }
}

# Verification de pdflatex
Write-Host "[3/5] Verification de l'installation LaTeX..." -ForegroundColor Yellow
try {
    $null = Get-Command pdflatex -ErrorAction Stop
    Write-Host "  OK pdflatex detecte" -ForegroundColor Green
    Write-Host ""
} catch {
    Write-Host "  ERREUR: pdflatex non trouve" -ForegroundColor Red
    Write-Host ""
    Write-Host "LaTeX n'est pas installe sur votre systeme." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "OPTIONS:" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Option 1: Installer MiKTeX (recommande)" -ForegroundColor White
    Write-Host "  1. Telecharger: https://miktex.org/download" -ForegroundColor Gray
    Write-Host "  2. Installer avec options par defaut" -ForegroundColor Gray
    Write-Host "  3. Relancer ce script" -ForegroundColor Gray
    Write-Host ""
    Write-Host "Option 2: Utiliser Overleaf (en ligne, gratuit)" -ForegroundColor White
    Write-Host "  1. Aller sur: https://www.overleaf.com" -ForegroundColor Gray
    Write-Host "  2. Creer un compte gratuit" -ForegroundColor Gray
    Write-Host "  3. New Project > Upload Project" -ForegroundColor Gray
    Write-Host "  4. Uploader rapport_devops.tex + dossier screenshots/" -ForegroundColor Gray
    Write-Host "  5. Cliquer sur Recompile" -ForegroundColor Gray
    Write-Host ""
    $openUrl = Read-Host "Ouvrir le site de telechargement MiKTeX ? (O/N)"
    if ($openUrl -eq "O" -or $openUrl -eq "o") {
        Start-Process "https://miktex.org/download"
    }
    exit 1
}

# Compilation LaTeX (3 passes pour table des matieres)
Write-Host "[4/5] Compilation du rapport LaTeX..." -ForegroundColor Yellow
Write-Host ""

Write-Host "  Pass 1/3: Compilation initiale..." -ForegroundColor Cyan
pdflatex -interaction=nonstopmode rapport_devops.tex > $null 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "  ERREUR lors de la compilation" -ForegroundColor Red
    Write-Host ""
    Write-Host "Tentative de compilation avec affichage des erreurs..." -ForegroundColor Yellow
    pdflatex -interaction=nonstopmode rapport_devops.tex
    exit 1
}
Write-Host "  OK Pass 1 terminee" -ForegroundColor Green

Write-Host "  Pass 2/3: Generation table des matieres..." -ForegroundColor Cyan
pdflatex -interaction=nonstopmode rapport_devops.tex > $null 2>&1
Write-Host "  OK Pass 2 terminee" -ForegroundColor Green

Write-Host "  Pass 3/3: Finalisation..." -ForegroundColor Cyan
pdflatex -interaction=nonstopmode rapport_devops.tex > $null 2>&1
Write-Host "  OK Pass 3 terminee" -ForegroundColor Green

Write-Host ""

# Nettoyage des fichiers temporaires
Write-Host "[5/5] Nettoyage des fichiers temporaires..." -ForegroundColor Yellow
$tempFiles = @("*.aux", "*.log", "*.out", "*.toc")
foreach ($pattern in $tempFiles) {
    Get-ChildItem -Filter $pattern -ErrorAction SilentlyContinue | Remove-Item -Force
}
Write-Host "  OK Fichiers temporaires supprimes" -ForegroundColor Green
Write-Host ""

# Verification du PDF genere
if (Test-Path "rapport_devops.pdf") {
    $pdfSize = (Get-Item "rapport_devops.pdf").Length / 1MB
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "  COMPILATION REUSSIE !                " -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Fichier genere:" -ForegroundColor Cyan
    Write-Host "  rapport_devops.pdf" -ForegroundColor White
    Write-Host "  Taille: $([math]::Round($pdfSize, 2)) MB" -ForegroundColor White
    Write-Host ""

    $openPdf = Read-Host "Ouvrir le PDF ? (O/N)"
    if ($openPdf -eq "O" -or $openPdf -eq "o") {
        Start-Process "rapport_devops.pdf"
        Write-Host ""
        Write-Host "PDF ouvert dans le lecteur par defaut." -ForegroundColor Green
    }

    Write-Host ""
    Write-Host "Le rapport PDF est pret pour votre presentation !" -ForegroundColor Green
    Write-Host ""
} else {
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "  ERREUR DE COMPILATION                " -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Le fichier PDF n'a pas ete genere." -ForegroundColor Red
    Write-Host "Verifiez les erreurs de compilation ci-dessus." -ForegroundColor Yellow
    Write-Host ""
}

Write-Host "INFORMATIONS COMPLEMENTAIRES:" -ForegroundColor Cyan
Write-Host "  - Fichier source: rapport_devops.tex" -ForegroundColor White
Write-Host "  - Documentation: LATEX_README.md" -ForegroundColor White
Write-Host "  - Captures: screenshots/" -ForegroundColor White
Write-Host ""

