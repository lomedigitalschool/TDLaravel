@echo off
echo Choisissez l'environnement :
echo 1. Local (SQLite)
echo 2. Docker/PostgreSQL
set /p choix="Votre choix (1 ou 2) : "

if "%choix%"=="1" (
    copy /Y .env.sqlite .env
    if errorlevel 1 (
        echo Erreur lors de la copie !
    ) else (
        echo Fichier .env.sqlite copié vers .env (mode local SQLite)
    )
    goto :fin
)

if "%choix%"=="2" (
    copy /Y .env.pgsql .env
    if errorlevel 1 (
        echo Erreur lors de la copie !
    ) else (
        echo Fichier .env.pgsql copié vers .env (mode Docker/PostgreSQL)
    )
    goto :fin
)

echo Choix invalide.

:fin
pause
