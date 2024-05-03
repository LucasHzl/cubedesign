CubeDesign - Site de e-commerce


CubeDesign est une plateforme de e-commerce spécialisée dans la vente de cubes aux couleurs des plus grands mouvements de design.

Ce README fournit des informations essentielles pour comprendre et démarrer avec le projet.



Installation

Cloner le dépôt :
git clone git@github.com:LucasHzl/cubedesign.git

Installer les dépendances :
composer install

Configurer l'environnement :
Créez un fichier .env.local à la racine du projet et configurez vos variables d'environnement, notamment pour la base de données et d'autres paramètres sensibles.

Créer la base de données :
php bin/console doctrine:database:create

Charger les fixtures :
php bin/console doctrine:fixtures:load

Démarrer le serveur de développement :
php bin/console symfony:server:start

Récuperer les identifiants d'administrateur :
DataFixtures/UsersFixture.php



Fonctionnalités principales

Catalogue de cubes : Parcourez et découvrez une large gamme de cubes inspirés par les grands mouvements de design.
Gestion des utilisateurs : Inscription, connexion et gestion de compte utilisateur.
Panier d'achat : Ajoutez des cubes à votre panier et passez commande en toute simplicité.
Backoffice Sysadmin : Interface d'administration pour gérer les produits, les commandes, les utilisateurs, etc.



Technologies utilisées

Symfony : Framework PHP pour le développement web.
Tailwind CSS : Framework pour le style.
Doctrine : ORM pour la gestion de la base de données.
Faker : Pour générer des données de test avec des fixtures réalistes.


Auteur : https://github.com/LucasHzl