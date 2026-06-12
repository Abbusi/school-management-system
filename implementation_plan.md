# Plan d'implémentation - KPI Dynamiques avec Seeders

Ce plan décrit les changements à apporter pour calculer dynamiquement les indicateurs de croissance (deltas) des cartes KPI du tableau de bord à partir de données historiques insérées par un seeder.

## Changements Proposés

### 1. Mise à jour des Seeders pour les Données Historiques
Nous allons modifier le seeder de l'application pour distribuer les dates de création (`created_at`) des étudiants, enseignants, employés et matières afin de calculer des métriques de croissance réalistes (par exemple, les inscriptions ou embauches de ce mois par rapport aux mois précédents).

#### [MODIFY] [DemoAppDataSeeder.php](file:///d:/Project/School%20MS/database/seeders/DemoAppDataSeeder.php)
- Étudiants :
  - 13 étudiants créés il y a 45 jours.
  - 2 étudiants créés il y a 5 jours (Total : 15).
  - Associer les dates `created_at` correspondantes dans la table `registrations`.
- Enseignants :
  - 5 enseignants créés il y a 60 jours.
  - 1 enseignant créé il y a 10 jours (Total : 6).
- Employés :
  - Passer de 3 employés à 9 employés.
  - 6 employés créés il y a 60 jours.
  - 3 employés créés il y a 10 jours (Total : 9).
- Matières :
  - 20 matières créées il y a 60 jours.
  - 2 matières créées il y a 10 jours (Total : 22).

### 2. Calcul Dynamique des Croissances dans le Contrôleur
Nous allons interroger la base de données dans le contrôleur pour calculer ces deltas au lieu de les coder en dur dans les templates Blade.

#### [MODIFY] [UserController.php](file:///d:/Project/School%20MS/app/Http/Controllers/Backend/UserController.php)
- Mettre à jour `getStatisticData()` ou ajouter des méthodes pour calculer les totaux et leurs croissances sur les 30 derniers jours.
- Formule de croissance pour chaque carte :
  - Étudiants : Nombre de nouveaux inscrits dans les 30 derniers jours (ex. `+2 ce mois` ou `+15,4% ce mois`).
  - Enseignants : Nouveaux enseignants sur les 30 derniers jours.
  - Employés : Nouveaux employés sur les 30 derniers jours.
  - Matières : Nouvelles matières sur les 30 derniers jours.

### 3. Liaison des variables dynamiques dans le Template Blade
#### [MODIFY] [dashboard.blade.php](file:///d:/Project/School%20MS/resources/views/backend/user/dashboard.blade.php)
- Remplacer les chaînes `delta` codées en dur par les variables dynamiques (ex. `$studentDelta`, `$teacherDelta`, `$employeeDelta`, `$subjectDelta`).

---

## Plan de vérification
1. Re-seeder la base de données : `php artisan db:seed --class=DemoAppDataSeeder`
2. Ouvrir le tableau de bord : `http://localhost:8001/dashboard`
3. Vérifier les totaux et deltas de croissance.
