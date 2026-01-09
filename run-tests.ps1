# Script PowerShell pour executer les tests

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Execution des tests                    " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Creer la base de donnees de test
Write-Host "[1/4] Preparation de la base de donnees de test..." -ForegroundColor Yellow
docker-compose exec -T php php bin/console doctrine:database:create --if-not-exists --env=test --no-interaction
docker-compose exec -T php php bin/console doctrine:migrations:migrate --env=test --no-interaction
Write-Host "Base de donnees de test prete" -ForegroundColor Green
Write-Host ""

# 2. Charger les fixtures de test
Write-Host "[2/4] Chargement des donnees de test..." -ForegroundColor Yellow
docker-compose exec -T php php bin/console doctrine:fixtures:load --env=test --no-interaction
if ($LASTEXITCODE -eq 0) {
    Write-Host "Donnees de test chargees" -ForegroundColor Green
} else {
    Write-Host "Fixtures non disponibles (non bloquant)" -ForegroundColor Yellow
}
Write-Host ""

# 3. Executer tous les tests
Write-Host "[3/4] Execution de tous les tests..." -ForegroundColor Yellow
docker-compose exec -T php php bin/phpunit --testdox
Write-Host ""

# 4. Afficher le resume
if ($LASTEXITCODE -eq 0) {
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "  Tous les tests sont passes!         " -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Cyan
} else {
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "  Certains tests ont echoue           " -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Cyan
}
Write-Host ""

# 5. Options supplementaires
Write-Host "[4/4] Commandes de test disponibles:" -ForegroundColor Yellow
Write-Host "  - Tests unitaires      : docker-compose exec php php bin/phpunit tests/Unit" -ForegroundColor White
Write-Host "  - Tests d'integration  : docker-compose exec php php bin/phpunit tests/Integration" -ForegroundColor White
Write-Host "  - Tests fonctionnels   : docker-compose exec php php bin/phpunit tests/Functional" -ForegroundColor White
Write-Host "  - Couverture de code   : docker-compose exec php php bin/phpunit --coverage-html coverage" -ForegroundColor White
Write-Host ""

