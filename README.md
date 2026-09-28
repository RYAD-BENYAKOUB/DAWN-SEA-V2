# 🌅 Dawn & Sea V2

Plateforme touristique de nouvelle génération connectant les guides touristiques en Algérie avec les voyageurs.

---

## Stack Technique

| Composant | Version |
|---|---|
| **Framework** | Laravel 13 |
| **PHP** | ≥ 8.3 (Docker: 8.4) |
| **Base de données** | PostgreSQL (Supabase) |
| **Frontend** | Tailwind CSS 3 + Vite 7 + Alpine.js |
| **Authentification** | Laravel Breeze + Spatie Permission |
| **Déploiement** | Docker → Railway |

---

## Architecture

Le projet suit une architecture **Action-Domain-Responder** :

- **Controllers** : valident la requête, délèguent aux Actions
- **DTOs** (`app/DTOs/`) : données validées et typées
- **Actions** (`app/Actions/`) : logique métier isolée
- **Exceptions** (`app/Exceptions/`) : gestion structurée des erreurs

---

## Installation locale

### Prérequis

- PHP 8.3+
- Composer
- Node.js 20+ & npm
- PostgreSQL (ou Supabase)

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/RYAD-BENYAKOUB/DAWN-SEA-V2.git
cd DAWN-SEA-V2

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate
# Modifier .env avec vos identifiants de base de données

# 4. Exécuter les migrations
php artisan migrate

# 5. Lancer les serveurs de développement
composer dev
# Ou dans deux terminaux séparés :
# php artisan serve
# npm run dev
```

---

## Déploiement sur Railway

### Architecture de déploiement

```
GitHub → Railway → Docker → Laravel → Supabase PostgreSQL
```

### Variables d'environnement Railway

| Variable | Requis | Description | Exemple |
|---|---|---|---|
| `APP_KEY` | ✅ | Clé de chiffrement Laravel | `base64:...` |
| `APP_URL` | ✅ | URL publique de l'application | `https://dawn-sea.railway.app` |
| `APP_ENV` | ✅ | Environnement | `production` |
| `APP_DEBUG` | ✅ | Mode debug | `false` |
| `DB_CONNECTION` | ✅ | Driver de base de données | `pgsql` |
| `DB_HOST` | ✅ | Hôte Supabase | `db.xxx.supabase.co` |
| `DB_PORT` | ✅ | Port PostgreSQL | `5432` |
| `DB_DATABASE` | ✅ | Nom de la base | `postgres` |
| `DB_USERNAME` | ✅ | Utilisateur | `postgres` |
| `DB_PASSWORD` | ✅ | Mot de passe | `(votre mot de passe)` |
| `DB_SSLMODE` | ✅ | Mode SSL | `require` |
| `LOG_STACK` | ✅ | Canal de log | `stderr` |
| `LOG_LEVEL` | ✅ | Niveau de log | `warning` |
| `SESSION_SECURE_COOKIE` | ✅ | Cookies HTTPS | `true` |
| `CORS_ALLOWED_ORIGINS` | ⚠️ | Origines CORS | `https://dawn-sea.railway.app` |

### Étapes de déploiement

1. **Créer un projet Railway** et connecter le dépôt GitHub
2. **Configurer les variables d'environnement** (voir tableau ci-dessus)
3. **Générer APP_KEY** : `php artisan key:generate --show`
4. Railway détecte automatiquement le `Dockerfile` et build l'image
5. **Vérifier le déploiement** : visiter `https://your-app.railway.app/up`

### Santé de l'application

- **Endpoint** : `GET /up`
- **Réponse attendue** : HTTP 200
- Utilisable comme health check Railway

### Créer le SuperAdmin

```bash
# Via Railway CLI ou console
php artisan app:create-superadmin --email=admin@example.com --password=your-secure-password
```

---

## Structure de la base de données

Tables principales :

| Table | Description |
|---|---|
| `users` | Utilisateurs (rôles: user, guide, admin, superadmin) |
| `guides` | Profils de guides |
| `programs` | Programmes touristiques |
| `favorites` | Programmes favoris des utilisateurs |
| `visits` | Statistiques de visite |
| `reviews` | Avis et notes sur les programmes |
| `sessions` | Sessions utilisateur (driver: database) |
| `cache` / `cache_locks` | Cache applicatif (driver: database) |
| `jobs` / `job_batches` / `failed_jobs` | File de tâches |
| Spatie Permission tables | Rôles et permissions |

---

## Docker

### Build local

```bash
docker build -t dawn-sea-v2 .
```

### Exécuter localement

```bash
docker run -p 8080:8080 \
  -e APP_KEY=base64:your-key \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  -e DB_CONNECTION=pgsql \
  -e DB_HOST=your-supabase-host \
  -e DB_PORT=5432 \
  -e DB_DATABASE=postgres \
  -e DB_USERNAME=postgres \
  -e DB_PASSWORD=your-password \
  -e DB_SSLMODE=require \
  -e LOG_STACK=stderr \
  -e PORT=8080 \
  dawn-sea-v2
```

---

## Sécurité

- Protection Mass-assignment (rôle non dans `$fillable`)
- Validation stricte (Form Requests + DTOs)
- Rate limiting (inscription, mot de passe oublié)
- Headers de sécurité (CSP, HSTS, X-Frame-Options)
- CSRF protection
- Middleware d'autorisation Spatie Permission

---

*Fait avec passion pour le tourisme algérien.* 🇩🇿
