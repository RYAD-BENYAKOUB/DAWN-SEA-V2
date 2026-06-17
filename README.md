# Dawn & Sea — Tourisme de Luxe en Algérie (V2)

**Dawn & Sea** est une plateforme moderne et performante de tourisme de luxe en Algérie. Elle permet de mettre en relation des voyageurs exigeants à la recherche d'expériences uniques avec des guides locaux certifiés proposant des circuits haut de gamme (désert, patrimoine culturel, littoral).

---

## 🎨 Design System — "Luxury Saharan Coast"
L'identité graphique est inspirée des paysages côtiers et sahariens de l'Algérie avec une orientation esthétique de luxe minimaliste :
- **Palette de Couleurs** : 
  - Fond Principal : Crème (`#FFF8F0`)
  - Accent / CTA : Or chaud (`#C5A55A`)
  - Texte secondaire / Bordures : Taupe (`#8B7D6B`)
  - Texte Principal : Charcoal (`#2C2C2C`)
- **Polices** :
  - Titres : *Playfair Display* (Serif sophistiqué)
  - Corps de texte et formulaires : *Inter* (Sans-serif lisible et moderne)
- **Composants** : Boutons avec arrondis complets (Pill-shaped), bordures douces, effet de flou en arrière-plan (glassmorphism) sur la barre de navigation et animations de zoom douces au survol des cartes de destination.

---

## 🚀 Fonctionnalités Clés
1. **Contrôle d'Accès par Rôles** :
   - Rôles définis via un enum : `user` (Voyageur) et `guide` (Guide certifié).
   - Middleware dédié `EnsureUserHasRole` protégeant les routes.
   - Redirection automatique intelligente lors de la connexion.
2. **Espace Voyageur** :
   - Fiche profil et formulaires de gestion de compte re-stylisés.
   - Galerie publique de programmes touristiques avec recherche en direct par mots-clés et filtres dynamiques (difficulté et budget).
3. **Espace Guide (Tableau de Bord)** :
   - Graphique analytique des visites mensuelles interactif généré avec **Google Charts**.
   - Indice de performance clé (KPI) : Visites globales, programmes actifs, nombre de favoris reçus, note moyenne.
   - Liste des ajouts récents aux favoris par les voyageurs.
   - Gestionnaire complet (CRUD) des programmes de voyage (Créer, modifier, désactiver et supprimer).

---

## 📂 Structure de Données (Base de Données)
- **`users`** : Table étendue avec le champ `role` (`user`, `guide`).
- **`guides`** : Profil professionnel (bio, téléphone, localisation, spécialité, note de satisfaction, statut de vérification).
- **`programs`** : Fiches d'expériences (titre, slug unique, description, localisation, durée, prix DA, limite de participants, difficulté, statut d'activité).
- **`favorites`** : Table de pivot (many-to-many) gérant les favoris des voyageurs.
- **`visits`** : Journal de trafic stockant les visites de programmes pour alimenter le graphique du guide.

---

## 🛠️ Technologies Utilisées
- **Backend** : Laravel 12 (avec Laravel Breeze pour l'authentification et les middlewares de rôles)
- **Base de données** : SQLite (via Eloquent ORM et Migrations)
- **Frontend** : Blade Templates, CSS3 personnalisé (Design System Dawn & Sea), Tailwind CSS (pour les utilitaires Breeze)
- **Interactivité & Analytics** : Alpine.js, Google Charts API (pour les graphiques d'analyse)
- **Build system** : Vite

---

## 🔑 Identifiants de Test (Données de démo)

Pour tester rapidement les différentes interfaces de l'application, connectez-vous avec les comptes suivants :

### 🧔 Espace Guide (Dashboard & Analytics)
- **Email** : `yacine@example.com`
- **Mot de passe** : `password`

### 👩 Espace Voyageur (Profil & Favoris)
- **Email** : `sara@example.com`
- **Mot de passe** : `password`
