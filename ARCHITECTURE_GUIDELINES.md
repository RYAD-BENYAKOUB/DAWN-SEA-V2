# Architecture Guidelines V2

## 1. Philosophie Générale
Ce projet suit une variante du pattern **Action-Domain-Responder (ADR)**. L'objectif est de maintenir des contrôleurs complètement **anémiques**. Toute la logique métier est reléguée dans le dossier `app/Actions/`.

### Principes Clés
- **Single Responsibility Principle (SRP)** : Une classe = une seule responsabilité.
- **Typage Strict** : Le code doit être typé au maximum, en s'appuyant sur PHP 8.2+ et les Data Transfer Objects (DTOs).
- **Découplage** : Les contrôleurs ne doivent jamais interagir directement avec la base de données pour insérer ou mettre à jour des données sans passer par une Action, excepté pour des requêtes de lecture simples (Query Builders / Eloquent).

---

## 2. Structure des Dossiers

| Dossier | Rôle |
|---|---|
| `app/Actions/` | Classes exécutant une logique métier spécifique (ex: `CreateProgramAction`). Elles ont une unique méthode `execute()`. |
| `app/DTOs/` | Data Transfer Objects. Objets immuables (`readonly`) qui valident et transmettent les données de la `Request` vers les Actions. |
| `app/Exceptions/` | Exceptions personnalisées qui héritent de `BaseBusinessException`. |
| `app/AI/` | Espaces réservés pour les intégrations LLM et les serveurs MCP. |
| `app/Services/` | Classes d'interface avec des systèmes externes (Supabase, API tierces). |

---

## 3. Flux de Données (Request Lifecycle)

1. **Route** : Définit le point d'entrée.
2. **Controller** : 
   - Reçoit la `Request`.
   - Construit le DTO via `CreateDTO::fromRequest($request)`.
   - Appelle l'Action via injection de dépendance.
   - Retourne la vue ou la réponse HTTP (`redirect`, `json`).
3. **DTO** : Valide la requête et type les données (plus d'utilisation de `$request->all()` ou de tableaux génériques).
4. **Action** : Contient la logique métier complexe (interactions BDD, appels API externes, émissions d'événements).
5. **Exceptions** : Si une condition métier n'est pas remplie, l'Action lance une exception qui sera catchée par le handler global.

---

## 4. Règles de Code
- **PSR-12** : Le code doit respecter strictement les normes de codage PSR-12.
- **DocBlocks** : Chaque Action et classe de Service doit contenir des annotations de type PHPDoc pour aider l'analyse statique et l'auto-complétion.
- **Retour de Types** : Toujours typer les arguments et les retours de méthodes (ex: `public function execute(DTO $dto): Model`).
- **Découplage de la DB** : Les contrôleurs ne font pas de `->save()` ou `->update()`.

*Ce document servira de référence à tout développeur, IA ou outil d'analyse statique rejoignant le projet.*
