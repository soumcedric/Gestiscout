#!/bin/sh
set -e

# On attend quelques secondes que la DB soit bien réveillée (optionnel)
echo "Attente de la base de données..."

# On lance les migrations automatiquement
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

# On lance le serveur PHP (votre commande d'origine)
exec php -S 0.0.0.0:8081 -t public