# Script de test simple
Write-Host "========================================" -ForegroundColor Green
Write-Host "  TEST SCRIPTS CORRIGES               " -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

Write-Host "Les scripts ont ete corriges." -ForegroundColor White
Write-Host "Tous les caracteres speciaux et emojis ont ete retires." -ForegroundColor White
Write-Host ""

Write-Host "Scripts disponibles:" -ForegroundColor Cyan
Write-Host "  1. capture-helper.ps1  - Assistant interactif" -ForegroundColor White
Write-Host "  2. generate-report.ps1 - Generateur PDF" -ForegroundColor White
Write-Host ""

Write-Host "Pour lancer l'assistant:" -ForegroundColor Yellow
Write-Host "  .\capture-helper.ps1" -ForegroundColor Gray
Write-Host ""

Write-Host "Verification des captures..." -ForegroundColor Cyan
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

$count = 0
foreach ($s in $screenshots) {
    if (Test-Path "screenshots\$s") {
        $count++
    }
}

Write-Host "  Captures presentes: $count / 14" -ForegroundColor White
Write-Host "  Captures manquantes: $(14 - $count)" -ForegroundColor Yellow
Write-Host ""

Write-Host "Tout est pret ! Vous pouvez maintenant:" -ForegroundColor Green
Write-Host "  1. Lancer: .\capture-helper.ps1" -ForegroundColor White
Write-Host "  2. Prendre les 14 captures d'ecran" -ForegroundColor White
Write-Host "  3. Generer le PDF avec: .\generate-report.ps1" -ForegroundColor White
Write-Host ""

