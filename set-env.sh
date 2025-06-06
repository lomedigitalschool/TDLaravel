#!/bin/bash

# Usage: ./set-env.sh sqlite | pgsql-local | docker

if [ -z "$1" ]; then
  echo "❌ Merci d'indiquer l'environnement (sqlite, pgsql-local, docker)"
  exit 1
fi

cp .env.base .env

case $1 in
  sqlite)
    cat .env.sqlite >> .env
    echo "✅ Fichier .env configuré pour SQLITE (artisan local)"
    ;;
  pgsql-local)
    cat .env.pgsql-local >> .env
    echo "✅ Fichier .env configuré pour PostgreSQL local"
    ;;
  docker)
    cat .env.docker >> .env
    echo "✅ Fichier .env configuré pour Docker"
    ;;
  *)
    echo "❌ Environnement inconnu. Utilisez: sqlite, pgsql-local, docker"
    exit 1
    ;;
esac
