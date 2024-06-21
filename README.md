Symfony Project README
Installation et Configuration
Créer un nouveau projet Symfony

bash

symfony new pe9_sf_news --version=6.4 --webapp


Créer un contrôleur :

bash

php bin/console make:controller



Voir toutes les routes :

bash

    php bin/console debug:router

Gestion des Styles avec Tailwind

    Installer Tailwind :

    bash

composer require symfonycasts/tailwind-bundle

Initialiser Tailwind :

bash

php bin/console tailwind:init

Construire Tailwind en mode watch :

bash

php bin/console tailwind:build --watch

Ajouter Flowbite :

bash

    php bin/console importmap:require flowbite

Base de Données

    Créer la base de données :

    bash

php bin/console doctrine:database:create


Créer une entité :

bash

php bin/console make:entity

Créer une migration :

bash

php bin/console make:migration

Exécuter les migrations :

bash

php bin/console doctrine:migrations:migrate


Fixtures et Fake Data

    Installer les fixtures :

    bash

composer require --dev orm-fixtures

Charger les fixtures :

bash

php bin/console doctrine:fixtures:load

Ajouter Faker :

bash

    composer require --dev fakerphp/faker



Docker et Mailtrap

    Installer et lancer Mailtrap avec Docker :

    bash

docker run -d --name=mailtrap -p 8940:80 -p 7321:25 eaudeweb/mailtrap

Envoyer un email avec Docker :

bash

    php bin/console messenger:consume async -vv

Suppression de Messenger

    Supprimer Messenger :

    bash

composer remove symfony/doctrine-messenger

Faire une migration après suppression :

bash

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate

CRUD et EasyAdmin

    Installer EasyAdmin :

    bash

composer require easycorp/easyadmin-bundle

Créer le tableau de bord admin :

bash

php bin/console make:admin:dashboard

Créer un CRUD admin :

bash

    php bin/console make:admin:crud

Sécurité

    Créer un utilisateur :

    bash

php bin/console make:user

Configurer la sécurité et créer un formulaire de login :

bash

php bin/console make:security:form-login

Définir les règles d'accès dans security.yaml :

yaml

    access_control:
      - { path: ^/admin, roles: ROLE_ADMIN }

API et Sérialisation

    Créer un contrôleur API :

    bash

php bin/console make:controller ApiTokenController

Ajouter un normalizer :

bash

    php bin/console make:serializer:normalizer

Gestion des Tokens

    Créer une entité ApiToken :

    bash

php bin/console make:user

Configurer le provider dans security.yaml :

yaml

providers:
  api_token_provider:
    entity:
      class: App\Entity\ApiToken
      property: token

Ajouter un firewall pour l'API :

yaml

    firewalls:
      api:
        pattern: ^/api/
        stateless: true
        api_token: true

Evénements

    Créer un listener :
        Créer le fichier dans src/EventListener
        Ajouter le tag dans services.yaml :

        yaml

        App\EventListener\MyListener:
          tags:
            - { name: 'kernel.event_listener', event: 'kernel.request' }

    Subscriber n'a pas besoin de configuration dans services.yaml.

Validation

    Créer un validateur pour spam :

    bash

php bin/console make:validator SpamValidator



Upload de fichiers
-à la main sur entity Recipe.
-avec vichuploadbundle sur entity category

Les event listener  et event subscribers les personnaliser.

API Spam Checker commnique avec une autre API .

