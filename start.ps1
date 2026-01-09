# Script PowerShell pour demarrer le projet Rent Cars avec Docker

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Demarrage de l'application Rent Cars  " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# 1. Demarrer les conteneurs Docker
Write-Host "[1/6] Demarrage des conteneurs Docker..." -ForegroundColor Yellow
docker-compose up -d --build
if ($LASTEXITCODE -ne 0) {
    Write-Host "Erreur lors du demarrage des conteneurs." -ForegroundColor Red
    exit 1
}
Write-Host "Conteneurs demarres avec succes" -ForegroundColor Green
Write-Host ""

# 2. Attendre que les services soient prets
Write-Host "[2/6] Attente du demarrage des services (15 secondes)..." -ForegroundColor Yellow
Start-Sleep -Seconds 15
Write-Host "Services prets" -ForegroundColor Green
Write-Host ""

# 3. Installer les dependances Composer
Write-Host "[3/6] Installation des dependances Composer..." -ForegroundColor Yellow
docker-compose exec -T php composer install --no-interaction --optimize-autoloader
if ($LASTEXITCODE -ne 0) {
    Write-Host "Erreur lors de l'installation des dependances." -ForegroundColor Red
    exit 1
}
Write-Host "Dependances installees" -ForegroundColor Green
Write-Host ""

# 4. Creer la base de donnees et executer les migrations
Write-Host "[4/6] Creation de la base de donnees et migrations..." -ForegroundColor Yellow
docker-compose exec -T php php bin/console doctrine:database:create --if-not-exists --no-interaction
docker-compose exec -T php php bin/console doctrine:migrations:migrate --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "Erreur lors de la creation de la base de donnees." -ForegroundColor Red
    exit 1
}
Write-Host "Base de donnees creee et migrations appliquees" -ForegroundColor Green
Write-Host ""

# 5. Charger les donnees de test (fixtures)
Write-Host "[5/6] Chargement des donnees de test..." -ForegroundColor Yellow
docker-compose exec -T php php bin/console doctrine:fixtures:load --no-interaction
if ($LASTEXITCODE -eq 0) {
    Write-Host "Donnees de test chargees" -ForegroundColor Green
} else {
    Write-Host "Fixtures non disponibles (non bloquant)" -ForegroundColor Yellow
}
Write-Host ""

# 6. Afficher le statut
Write-Host "[6/6] Verification du statut des conteneurs..." -ForegroundColor Yellow
docker-compose ps
Write-Host ""

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Installation terminee avec succes!    " -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Application disponible sur: http://localhost:8080" -ForegroundColor Green
Write-Host ""
Write-Host "Commandes utiles:" -ForegroundColor Yellow
Write-Host "  - Voir les logs        : docker-compose logs -f" -ForegroundColor White
Write-Host "  - Arreter l'app        : docker-compose down" -ForegroundColor White
Write-Host "  - Executer les tests   : docker-compose exec php php bin/phpunit" -ForegroundColor White
Write-Host "  - Acceder au conteneur : docker-compose exec php bash" -ForegroundColor White
Write-Host ""

