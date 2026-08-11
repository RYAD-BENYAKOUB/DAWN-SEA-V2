# Documentation du Projet : Dawn & Sea (Tourisme Algérie)

## Introduction
**Dawn & Sea** est une application web dédiée à la promotion du tourisme en Algérie. Elle met en relation les passionnés de voyage avec des guides locaux (organisateurs) proposant des programmes et itinéraires touristiques authentiques.

## Stack Technologique & Architecture
Le projet est bâti sur une architecture MVC (Modèle-Vue-Contrôleur) classique en utilisant le framework **Laravel**.

*   **Back-end :** PHP 8.x avec Laravel 13.x
*   **Front-end :** Blade (Moteur de templates de Laravel), TailwindCSS pour le style, et Alpine.js pour la réactivité JavaScript.
*   **Asset Bundler :** Vite
*   **Base de données :** PostgreSQL (via PDO)
*   **Gestion des rôles :** Spatie Laravel Permission
*   **Authentification :** Laravel Breeze (sessions classiques)

## Modèles Principaux (Base de Données)
L'application repose sur les entités (modèles Eloquent) suivantes :

1.  **User (Utilisateur) :** Représente toute personne authentifiée sur la plateforme. Un utilisateur peut avoir différents rôles (voir section Rôles).
2.  **Program (Programme/Itinéraire) :** Représente un circuit ou une offre touristique créée par un Organisateur. Un programme possède généralement un titre, une description, des dates, un prix et des médias associés.
3.  **Guide :** Profil détaillé d'un organisateur touristique (compétences, présentation, etc.).
4.  **Destination :** Représente un lieu géographique (ville, région, site touristique).
5.  **Review (Avis) :** Les utilisateurs peuvent laisser des avis et des notes sur les programmes.
6.  **Visit (Visite) :** Suivi des visites/réservations liées à un programme.
7.  **Favorite (Favoris) :** Permet aux utilisateurs de sauvegarder leurs programmes préférés.

## Gestion des Rôles et Autorisations
Le système utilise le package `spatie/laravel-permission` pour gérer les droits d'accès. Il existe 3 niveaux principaux d'utilisateurs :

*   **SuperAdmin :** Accès total à la plateforme. Dispose d'un tableau de bord spécifique (`/dashboard/superadmin`) permettant la gestion des utilisateurs (ex: assigner le rôle d'Organisateur à un utilisateur).
*   **Organisateur (Guide) :** Créateur de contenu touristique. Possède un tableau de bord dédié (`/dashboard/guide`) pour créer, modifier, et supprimer ses programmes, ainsi que pour consulter ses statistiques (`/dashboard/stats`).
*   **Utilisateur classique :** Peut consulter les programmes, les destinations, contacter les guides, ajouter des programmes aux favoris, et laisser des avis. Son espace privé se résume principalement à la gestion de son profil (`/profile`).

## Architecture du Routage (Web)
Les routes sont définies dans `routes/web.php` et sont réparties ainsi :

1.  **Routes Publiques :**
    *   Accueil (`/`)
    *   Catalogue des programmes (`/programs`, `/programs/{slug}`)
    *   Liste des guides et destinations (`/guides`, `/destinations`)
    *   Page de contact (`/contact`)
2.  **Routes Authentifiées (Globales) :**
    *   Gestion du profil (`/profile`)
    *   Actions d'engagement : Ajout aux favoris (`/programs/{program}/favorite`), soumission et suppression d'avis (`/programs/{program}/reviews`).
3.  **Redirection Intelligente (`/dashboard`) :**
    *   Redirige l'utilisateur vers son tableau de bord spécifique selon son rôle (`SuperAdmin`, `Organisateur`, ou `Profile` par défaut).
4.  **Routes Réservées (Middlewares `role:xxx`) :**
    *   Espace Organisateur : CRUD des programmes.
    *   Espace SuperAdmin : Visualisation et modification des rôles utilisateurs.

## Fonctionnement Global (Flux Utilisateur)

1.  **Découverte :** Un visiteur non-authentifié navigue sur le site, découvre les destinations et les programmes touristiques.
2.  **Engagement :** Le visiteur crée un compte (géré par Laravel Breeze). Une fois authentifié, il peut mettre des programmes en favoris ou commenter.
3.  **Organisation :** Un utilisateur souhaitant devenir guide contacte l'administration. Un `SuperAdmin` lui attribue le rôle `Organisateur`.
4.  **Création :** Le nouvel `Organisateur` accède à son dashboard métier. Il crée ses programmes (titre, dates, etc.). Ces programmes deviennent visibles publiquement.
5.  **Réservation / Visite :** Les utilisateurs s'inscrivent ou planifient des visites via les entités `Visit`.

---
*Ce document sert de base de compréhension pour les développeurs et intervenants techniques. Il ne contient aucune donnée sensible de l'environnement de production.*
