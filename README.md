# 🌅 Dawn & Sea (V2)

Bienvenue sur le dépôt officiel de **Dawn & Sea V2**, la plateforme touristique de nouvelle génération développée par **Addou Houssem** et **Mohammed Ryad Benyakoub**.

Cette application a pour objectif de connecter les guides touristiques en Algérie avec les voyageurs, en offrant une interface utilisateur premium, une gestion avancée des programmes et des destinations, et une architecture robuste prête à intégrer l'Intelligence Artificielle.

---

## 🛠️ Stack Technique

- **Framework Backend** : [Laravel 12](https://laravel.com/)
- **Frontend & UI** : [Tailwind CSS](https://tailwindcss.com/) (compilé via Vite)
- **Base de données** : PostgreSQL / SQLite
- **Stockage de Médias** : [Supabase Storage](https://supabase.com/) (intégration en cours)
- **Authentification** : Laravel Breeze

---

## 🏗️ Architecture Logicielle (Action-Domain-Responder)

Pour garantir une évolutivité maximale et la capacité d'intégration avec des serveurs MCP (Model Context Protocol) pour l'Intelligence Artificielle, le projet suit une architecture hautement découplée :

- **Controllers Anémiques** : Les contrôleurs HTTP (ex: `ProgramController`) ne contiennent aucune logique métier. Ils se contentent de valider la requête et d'appeler des Actions.
- **DTOs (Data Transfer Objects)** : Toutes les requêtes entrantes sont validées et fortement typées via des DTOs (situés dans `app/DTOs/`) avant d'être passées aux couches inférieures.
- **Actions** : La logique métier pure (création, mise à jour, suppression, appels externes) est isolée dans des classes dédiées (situées dans `app/Actions/`) suivant le *Single Responsibility Principle*.
- **Exceptions de Domaine** : Une gestion structurée des erreurs est en place avec des exceptions personnalisées (héritant de `app/Exceptions/BaseBusinessException.php`).

> Pour plus de détails sur les normes de développement, consultez le fichier [`ARCHITECTURE_GUIDELINES.md`](ARCHITECTURE_GUIDELINES.md).

---

## 🚀 Fonctionnalités Principales

- **🧑‍💼 Espace Utilisateurs & Guides** : Inscription, rôles distincts (Utilisateur vs Guide), gestion de profil et sécurisation stricte des champs.
- **🗺️ Programmes Touristiques** : Création, édition et suppression de programmes de voyage par les guides (Titre, Lieu, Prix, Difficulté, Durée, Limite de participants).
- **🏖️ Destinations** : Exploration de diverses destinations algériennes.
- **📊 Tableaux de Bord (Dashboards)** :
  - *Guides* : Statistiques des visites de leurs programmes, gestion de leur catalogue.
  - *SuperAdmin* : Vue globale des utilisateurs, statistiques système.
- **📈 Tracking Analytique** : Suivi des visites par programme et statistiques temporelles fluides.

---

## ⚙️ Installation & Lancement Local

### Pré-requis
- PHP 8.2 ou supérieur
- Composer
- Node.js (v18+) & NPM

### Étapes

1. **Cloner le projet**
   ```bash
   git clone https://github.com/RYAD-BENYAKOUB/DAWN-SEA-V2.git
   cd DAWN-SEA-V2
   ```

2. **Installer les dépendances PHP et Node**
   ```bash
   composer install
   npm install
   ```

3. **Configuration de l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Assurez-vous de configurer votre base de données (ex: `DB_CONNECTION=sqlite`) dans le `.env`.*

4. **Migrations et Seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Lancer les serveurs de développement**
   Ouvrez deux terminaux et exécutez :
   ```bash
   # Terminal 1 : Serveur Backend Laravel
   php artisan serve

   # Terminal 2 : Compilation des assets (Vite)
   npm run dev
   ```

---

## 🤖 Préparation pour l'Intelligence Artificielle

Ce dépôt intègre un dossier `app/AI/` prêt à recevoir :
- **Serveurs MCP (Model Context Protocol)** : Pour interagir directement avec des LLM sans exposer de clés d'API dans le front-end.
- **Moteurs de recommandation** : Pour suggérer des programmes adaptés au profil des utilisateurs.

---

## 🔒 Sécurité
Une vigilance particulière a été accordée à la sécurité :
- Protection contre l'**Escalade de privilèges** (Mass-assignment désactivé sur les rôles).
- **Validation stricte** des payloads (Form Requests + DTOs).
- **Dependencies** : Audits NPM et Composer automatisés.

---
*Fait avec passion pour le tourisme algérien.* 🇩🇿
