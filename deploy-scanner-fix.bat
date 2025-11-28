@echo off
echo ================================================
echo   DEPLOIEMENT MAXIDOC - Correction Scanner
echo ================================================
echo.

REM Vérifier si Git est configuré
git status >nul 2>&1
if errorlevel 1 (
    echo [ERREUR] Git n'est pas configuré dans ce repertoire
    pause
    exit /b 1
)

echo [1/4] Ajout des fichiers modifies...
git add routes/web.php
git add app/Http/Controllers/Courriers/CourrierController.php
git add resources/views/livewire/courrier/add-courrier-form.blade.php

echo [2/4] Commit des modifications...
git commit -m "Fix: Correction route scanner avec prefix regidoc + logs detailles"

echo [3/4] Push vers le depot distant...
git push

echo.
echo [4/4] IMPORTANT - Actions manuelles requises:
echo.
echo 1. Connectez-vous au serveur de production
echo 2. Executez: cd /home/u115315654/domains/maxidoc-lp.newtech-rdc.net
echo 3. Executez: git pull
echo 4. Executez: php artisan optimize:clear
echo.
echo OU utilisez cette URL pour vider le cache:
echo https://maxidoc-lp.newtech-rdc.net/clear-all-cache-temp-2024
echo.
echo ================================================
pause
