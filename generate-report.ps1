# Script PowerShell pour générer le rapport PDF automatiquement
# Usage: .\generate-report.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  GÉNÉRATION DU RAPPORT PDF           " -ForegroundColor Cyan
Write-Host "  Projet Rent Cars - DevOps           " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Créer le dossier screenshots s'il n'existe pas
Write-Host "[1/5] Création du dossier screenshots..." -ForegroundColor Yellow
if (!(Test-Path "screenshots")) {
    New-Item -ItemType Directory -Path "screenshots" -Force | Out-Null
    Write-Host "✅ Dossier screenshots créé" -ForegroundColor Green
} else {
    Write-Host "✅ Dossier screenshots existe déjà" -ForegroundColor Green
}
Write-Host ""

# 2. Vérifier les captures d'écran manquantes
Write-Host "[2/5] Vérification des captures d'écran..." -ForegroundColor Yellow
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
        Write-Host "  ✅ $screenshot" -ForegroundColor Green
    } else {
        Write-Host "  ❌ $screenshot (MANQUANT)" -ForegroundColor Red
        $missing += $screenshot
    }
}
Write-Host ""

if ($missing.Count -gt 0) {
    Write-Host "⚠️  ATTENTION: $($missing.Count) capture(s) manquante(s)" -ForegroundColor Yellow
    Write-Host "Vous devez créer ces captures avant de générer le PDF:" -ForegroundColor Yellow
    foreach ($m in $missing) {
        Write-Host "  - $m" -ForegroundColor Red
    }
    Write-Host ""
    Write-Host "Consultez CHECKLIST_SCREENSHOTS.md pour savoir comment les créer." -ForegroundColor Cyan
    Write-Host ""
}

# 3. Prendre quelques captures automatiques si possible
Write-Host "[3/5] Tentative de captures automatiques..." -ForegroundColor Yellow

# Capture 4: docker-compose ps
if (!(Test-Path "screenshots\04_docker_ps.png")) {
    Write-Host "  Tentative de capture: docker-compose ps" -ForegroundColor Cyan
    try {
        $output = docker-compose ps 2>&1
        if ($LASTEXITCODE -eq 0) {
            # Sauvegarder la sortie dans un fichier texte
            $output | Out-File "screenshots\04_docker_ps.txt" -Encoding UTF8
            Write-Host "  ✅ Sortie sauvegardée dans 04_docker_ps.txt" -ForegroundColor Green
            Write-Host "     (Faire une capture d'écran du terminal et la nommer 04_docker_ps.png)" -ForegroundColor Yellow
        }
    } catch {
        Write-Host "  ⚠️  Docker containers non démarrés" -ForegroundColor Yellow
    }
}

# Capture 6: PHPUnit
if (!(Test-Path "screenshots\06_phpunit_results.png")) {
    Write-Host "  Tentative de capture: PHPUnit results" -ForegroundColor Cyan
    try {
        $output = docker-compose exec -T php php bin/phpunit 2>&1
        if ($LASTEXITCODE -eq 0) {
            $output | Out-File "screenshots\06_phpunit_results.txt" -Encoding UTF8
            Write-Host "  ✅ Sortie sauvegardée dans 06_phpunit_results.txt" -ForegroundColor Green
            Write-Host "     (Faire une capture d'écran du terminal et la nommer 06_phpunit_results.png)" -ForegroundColor Yellow
        }
    } catch {
        Write-Host "  ⚠️  Tests non exécutables" -ForegroundColor Yellow
    }
}

Write-Host ""

# 4. Ouvrir le HTML dans le navigateur
Write-Host "[4/5] Ouverture du rapport HTML..." -ForegroundColor Yellow
if (Test-Path "RAPPORT_DEVOPS.html") {
    Start-Process "RAPPORT_DEVOPS.html"
    Write-Host "✅ Rapport ouvert dans le navigateur" -ForegroundColor Green
} else {
    Write-Host "❌ Fichier RAPPORT_DEVOPS.html introuvable" -ForegroundColor Red
}
Write-Host ""

# 5. Instructions finales
Write-Host "[5/5] Instructions pour générer le PDF:" -ForegroundColor Yellow
Write-Host ""
Write-Host "ETAPE 1: Inserer les captures d'ecran" -ForegroundColor Cyan
Write-Host "  1. Ouvrir RAPPORT_DEVOPS.html dans un editeur de texte" -ForegroundColor White
Write-Host "  2. Remplacer chaque <div class='screenshot-placeholder'> par:" -ForegroundColor White
Write-Host "     <img src='screenshots/XX_nom.png' style='width: 100%;'>" -ForegroundColor Gray
Write-Host ""

Write-Host "ETAPE 2: Personnaliser le rapport" -ForegroundColor Cyan
Write-Host "  1. Remplacer [VOTRE NOM ICI] par votre nom" -ForegroundColor White
Write-Host "  2. Remplacer [votre.email@example.com] par votre email" -ForegroundColor White
Write-Host "  3. Remplacer 'username' par votre Docker Hub username" -ForegroundColor White
Write-Host ""

Write-Host "ETAPE 3: Convertir en PDF (METHODE RAPIDE)" -ForegroundColor Cyan
Write-Host "  1. Dans le navigateur, appuyer sur Ctrl+P" -ForegroundColor White
Write-Host "  2. Destination: Microsoft Print to PDF" -ForegroundColor White
Write-Host "  3. ✅ IMPORTANT: Activer 'Graphiques en arrière-plan'" -ForegroundColor Yellow
Write-Host "  4. Format: A4, Portrait, Marges normales" -ForegroundColor White
Write-Host "  5. Cliquer sur 'Enregistrer'" -ForegroundColor White
Write-Host "  6. Nommer: Rapport_DevOps_RentCars.pdf" -ForegroundColor White
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  ALTERNATIVE AUTOMATIQUE (AVANCÉ)     " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Si vous avez Google Chrome installé, vous pouvez générer le PDF automatiquement:" -ForegroundColor White
Write-Host ""
$chrome = "C:\Program Files\Google\Chrome\Application\chrome.exe"
if (Test-Path $chrome) {
    Write-Host "✅ Chrome détecté. Commande de conversion automatique:" -ForegroundColor Green
    Write-Host ""
    Write-Host "  & '$chrome' --headless --disable-gpu --print-to-pdf=Rapport_DevOps_RentCars.pdf RAPPORT_DEVOPS.html" -ForegroundColor Gray
    Write-Host ""
    $response = Read-Host "Voulez-vous générer le PDF automatiquement maintenant ? (O/N)"
    if ($response -eq "O" -or $response -eq "o") {
        Write-Host ""
        Write-Host "Génération du PDF en cours..." -ForegroundColor Yellow
        & $chrome --headless --disable-gpu --print-to-pdf="Rapport_DevOps_RentCars.pdf" --print-to-pdf-no-header "RAPPORT_DEVOPS.html"
        Start-Sleep -Seconds 2
        if (Test-Path "Rapport_DevOps_RentCars.pdf") {
            Write-Host "✅ PDF généré avec succès: Rapport_DevOps_RentCars.pdf" -ForegroundColor Green
            Write-Host ""
            $openPdf = Read-Host "Voulez-vous ouvrir le PDF ? (O/N)"
            if ($openPdf -eq "O" -or $openPdf -eq "o") {
                Start-Process "Rapport_DevOps_RentCars.pdf"
            }
        } else {
            Write-Host "❌ Erreur lors de la génération du PDF" -ForegroundColor Red
        }
    }
} else {
    Write-Host "⚠️  Chrome non détecté. Utilisez la méthode manuelle." -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  RESSOURCES UTILES                    " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "RAPPORT_DEVOPS.html        - Rapport HTML a convertir" -ForegroundColor White
Write-Host "CHECKLIST_SCREENSHOTS.md   - Guide des captures d'ecran" -ForegroundColor White
Write-Host "GUIDE_CONVERSION_PDF.md    - Guide de conversion detaille" -ForegroundColor White
Write-Host "screenshots/               - Dossier pour vos captures" -ForegroundColor White
Write-Host ""

Write-Host "========================================" -ForegroundColor Green
Write-Host "  SCRIPT TERMINE                       " -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Bonne chance pour votre presentation !" -ForegroundColor Cyan
Write-Host ""

