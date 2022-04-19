# EcoWeb

EcoWeb est une plateforme d'apprentissage en ligne permettant de suivre des formations pour un développement éco-responsable.
C'est la plateforme learning développée par l'organisation EcoIT.
Projet réalisé dans le cadre de l'Evaluation en Cours de Formation de la session juin 2022 pour Digital Campus Live - Studi par Aure LUCE.

## Table des matières

1. Environnement de développement
2. Tester en local
3. Annexes


## I. Environnement de développement

**FRONT :** 
- HTML5, CSS3, JavaScript et JQuery, Bootstrap 5

**BACK :** 
- PHP8, Symfony6 avec Symfony CLI et Composer, EasyAdmin

**SERVEUR :** 
- MySQL (MariaDB 10.4.21) avec XAMPP, ClearDB add-on pour Heroku

## II. Tester en local

Vous devez disposer d'un serveur local.
Attention à bien disposer de Composer à jour.

Cloner le projet :

```bash
  git clone https://github.com/highrankedfox/ECOWEB
```

Vérifier les dépendances :

```bash
  symfony check:requirements
```

Création de la base de données locale :
La création d'un .env avec les informations du serveur local est requise.

```bash
  symfony console doctrine:database:create
```

Exécuter les migrations :
```
symfony console doctrine:migrations:migrate
```

Lancer le serveur local :

```bash
  symfony server:start
```

## III. Annexes

Liste des documents dans le dossier annexes :
- Charte Graphique
- Documentation technique
- Manuel d'utilisation
- Captures d'écrans du Trello du projet

Wireframe interactif UIzard :
- Accueil, connexion, inscription apprenant et formateur, consulter le catalogue et les formations : https://app.uizard.io/p/32b6d7a0
