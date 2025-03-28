# Realty

School Project front and back

## Description

Realty est un projet scolaire qui comprend le développement d'une application web pour la gestion immobilière. Ce projet inclut à la fois le développement frontend et backend.

## Technologies utilisées

- **PHP**: 69%
- **CSS**: 17.5%
- **PLpgSQL**: 5.9%
- **JavaScript**: 5.8%
- **Hack**: 1.8%

## Fonctionnalités

- Gestion des propriétés immobilières
- Recherche avancée des propriétés
- Authentification et gestion des utilisateurs
- Visualisation des propriétés sur une carte
- Système de réservation en ligne

## Installation

Pour installer et exécuter ce projet en local, suivez les étapes suivantes:

1. Clonez le repository:

   ```bash
     git clone https://github.com/TomuCard/Realty.git
   ```
2.Accédez au répertoire du projet:

  ```bash
    cd Realty
  ```

Installez les dépendances backend:
  
  ```bash
    composer install
  ```

Installez les dépendances frontend:
  
  ```bash
    npm install
  ```

Configurez la base de données:

    Créez une base de données PostgreSQL.
    Importez le fichier database.sql dans votre base de données.

Configurez les variables d'environnement:

Créez un fichier .env à la racine du projet et ajoutez les configurations nécessaires:
  ```env
    DB_HOST=your_database_host
    DB_PORT=your_database_port
    DB_NAME=your_database_name
    DB_USER=your_database_user
    DB_PASS=your_database_password
  ```

Démarrez le serveur de développement:
  
  ```bash
    php artisan serve
    npm run dev
  ```
