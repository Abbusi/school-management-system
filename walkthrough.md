# Walkthrough - KPI Dynamiques avec Seeders

Nous avons configuré le calcul dynamique des indicateurs de croissance (deltas) pour les cartes KPI de l'administration, avec des seeders pour générer de manière réaliste des données historiques.

## Modifications réalisées

### 1. [DemoAppDataSeeder.php](file:///d:/Project/School%20MS/database/seeders/DemoAppDataSeeder.php)
- Les dates `created_at` ont été échelonnées :
  - **Étudiants** (15 au total) : 13 créés il y a 45 jours et 2 créés il y a 5 jours.
  - **Enseignants** (6 au total) : 5 créés il y a 60 jours et 1 créé il y a 10 jours.
  - **Employés** (9 au total) : 6 créés il y a 60 jours et 3 créés il y a 10 jours.
  - **Matières** (22 au total) : 20 créées il y a 60 jours et 2 créées il y a 10 jours.

### 2. [UserController.php](file:///d:/Project/School%20MS/app/Http/Controllers/Backend/UserController.php)
- Ajout de la méthode `getGrowthDelta($total, $newCount)` pour calculer dynamiquement le pourcentage ou le nombre de nouveaux éléments ajoutés au cours des 30 derniers jours.
- Remplacement du tableau de valeurs statiques de `getStatisticData` par un retour de données dynamique basé sur les dates de création réelles.
- Passage des variables de croissance `$studentDelta`, `$teacherDelta`, `$employeeDelta` et `$subjectDelta` au template du Dashboard.

### 3. [dashboard.blade.php](file:///d:/Project/School%20MS/resources/views/backend/user/dashboard.blade.php)
- Les paramètres statiques `delta` ont été reliés aux variables dynamiques de croissance.

---

## Validation
- La commande `php artisan db:seed --class=DemoAppDataSeeder` s'est exécutée avec succès.
- Les caches Laravel et les vues compilées ont été vidés via `php artisan cache:clear` et `php artisan view:clear`.
