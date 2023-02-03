# Symfony Docker (PHP8 / Caddy / Postgresql)

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework, with full [HTTP/2](https://symfony.com/doc/current/weblink.html), HTTP/3 and HTTPS support.

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell) or Run `docker compose up -d` to run in background 
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.
6. Run `docker compose logs -f` to display current logs, `docker compose logs -f [CONTAINER_NAME]` to display specific container's current logs 

## Commandes utiles
Lister l'ensemble des commandes existances `docker compose exec php bin/console`

#### Création de fichier vierge
Controller `docker compose exec php bin/console make:controller`

FormType `docker compose exec php bin/console make:form`

CRUD `docker compose exec php bin/console make:crud`

## Gestion de base de données

#### Commandes de création des fichiers entity/repository et d'ajout de champs
`docker compose exec php bin/console make:entity`

Documentation sur les relations entre les entités [https://symfony.com/doc/current/doctrine/associations.html](https://symfony.com/doc/current/doctrine/associations.html)

#### Mise à jour de la base de données via migration
Generation d'une migration

`docker compose exec php bin/console make:migration`

Jouer les migrations

`docker compose exec php bin/console doctrine:migration:migrate`

`docker compose exec php bin/console d:m:m`

#### Mise à jour de la base de données via update de schema sans migration
Voir les requètes interprétées (sans mise à jour de la DB)

`docker compose exec php bin/console doctrine:schema:update --dump-sql`

`docker compose exec php bin/console d:s:u --dump-sql`

Executer les requètes en DB

`docker compose exec php bin/console doctrine:schema:update --force`

`docker compose exec php bin/console d:s:u --force`

### Bundles
Installation bundle email

`docker compose exec php composer require symfonycasts/verify-email-bundle`

`docker compose exec php composer require symfony/sendinblue-mailer`

`docker compose exec php composer require symfony/mailer`

`docker compose exec php composer require symfony/sendgrid-mailer`

Installation bundle reset password

`docker compose exec php composer require symfonycasts/reset-password-bundle`

Installation bundle Vich uploader

`docker compose exec php composer require vich/uploader-bundle`

Installation npm

`docker compose exec php npm install`

`docker compose exec php npm run build`

`docker compose exec php npm run watch`