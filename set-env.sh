#!/bin/bash

# set-env.sh : Permet de basculer rapidement entre les environnements 'local' et 'docker'

ENV=$1

if [ -z "$ENV" ]; then
  echo "❌ Veuillez spécifier l’environnement : local ou docker"
  echo "✅ Exemple : ./set-env.sh local"
  exit 1
fi

if [ "$ENV" = "local" ]; then
  cp .env.local .env
  echo "✅ Environnement LOCAL activé."
  echo "🔄 Redémarrage des services Laravel en local..."
  
  # Exécution de la migration et du seeding
  php artisan config:clear
  php artisan migrate:fresh --seed

  echo "🌐 Accès à l'application : http://localhost:8000"
  echo "✅ Base de données réinitialisée et données de test insérées."

elif [ "$ENV" = "docker" ]; then
  cp .env.docker .env
  echo "✅ Environnement DOCKER activé."
  echo "🐳 Redémarrage de Docker Compose..."
  
  docker compose down
  docker compose up -d --build

  # Exécute les commandes dans le conteneur app
  echo "⏳ Exécution de php artisan migrate:fresh --seed dans le conteneur..."
  docker compose exec app php artisan config:clear
  docker compose exec app php artisan migrate:fresh --seed

  echo "🌐 Accès à l'application : http://157.180.38.74:9010"
  echo "✅ Base de données réinitialisée et données de test insérées."

else
  echo "❌ Environnement inconnu : $ENV"
  echo "Veuillez choisir 'local' ou 'docker'"
  exit 1
fi
