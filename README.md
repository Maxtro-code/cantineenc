# 🍽️ Cantine ENC Bessières

Application web de gestion de la restauration scolaire de l'ENC Bessières (Paris 17e), développée dans le cadre du BTS SIO SLAM — Session 2026.

Cette application remplace le système existant en corrigeant ses failles de sécurité (mots de passe en clair, gestion de session partielle) tout en conservant les mêmes fonctionnalités.

---

## ✨ Fonctionnalités

- Connexion sécurisée (mots de passe hachés avec bcrypt)
- Inscription désactivée — les comptes sont créés par l'administrateur
- Tableau de bord avec les prochains repas réservés
- Consultation du menu de la semaine
- Réservation de repas (lundi au vendredi uniquement)
- Annulation d'une réservation à venir
- Panneau d'administration : créer des comptes, gérer les rôles

---

## 🛠️ Stack technique

| Élément | Technologie |
|---|---|
| Framework | Laravel 11 |
| Authentification | Laravel Jetstream + Fortify |
| Interface | Blade + Tailwind CSS + Alpine.js |
| Base de données | MySQL 8 |
| ORM | Eloquent |
| Gestion de versions | Git + GitHub |

---

## ⚙️ Installation

### Prérequis

- PHP 8.2+
- Composer
- Node.js 20+ / npm
- MySQL 8
- Laragon (recommandé sur Windows)

### Étapes

**1. Cloner le dépôt**
```bash
git clone https://github.com/Maxtro-code/cantineenc.git
cd cantineenc
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

Puis éditer `.env` et renseigner la base de données :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cantineenc
DB_USERNAME=root
DB_PASSWORD=
```

**4. Créer la base de données**

Ouvrir phpMyAdmin (ou MySQL) et créer une base nommée `cantineenc`.

**5. Lancer les migrations et le seeder**
```bash
php artisan migrate
php artisan db:seed
```

**6. Installer les dépendances front-end**
```bash
npm install
npm run build
```

**7. Lancer le serveur**
```bash
php artisan serve
```

L'application est accessible sur [http://localhost:8000](http://localhost:8000)

---

## 🔑 Comptes de démonstration

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@enc-bessieres.org` | `AdminENC2026!` |
| Étudiant | `marie.dupont@enc-bessieres.org` | `Soleil42!MD` |

---

## 📁 Structure du projet

```
cantineenc/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php       # Gestion des utilisateurs
│   │   │   ├── MenuController.php        # Menu de la semaine
│   │   │   └── ReservationController.php # Réservations
│   │   └── Middleware/
│   │       └── AdminMiddleware.php       # Protection routes admin
│   └── Models/
│       ├── User.php
│       └── Reservation.php
├── database/
│   ├── migrations/                       # Schéma de la base de données
│   └── seeders/
│       └── DatabaseSeeder.php            # Données de démonstration
├── resources/views/
│   ├── auth/                             # Pages login / register
│   ├── pages/
│   │   ├── admin/                        # Panneau administration
│   │   ├── menu-semaine.blade.php        # Menu hebdomadaire
│   │   └── info-user_cantine.blade.php   # Informations pratiques
│   ├── reservations/
│   │   └── index.blade.php               # Gestion des réservations
│   ├── dashboard.blade.php               # Tableau de bord
│   └── welcome.blade.php                 # Page de connexion
└── routes/
    └── web.php                           # Toutes les routes
```

---

## 🔒 Sécurité

- Mots de passe hachés avec **bcrypt** via `Hash::make()`
- Inscription désactivée (routes `/register` bloquées)
- Middleware `auth` sur toutes les pages privées
- Middleware `admin` sur le panneau d'administration
- Protection **CSRF** sur tous les formulaires
- Vérification d'appartenance sur la suppression de réservation (anti-IDOR)
- Génération de mot de passe temporaire conforme aux recommandations **ANSSI**

---

## 📋 Règles métier

- Les réservations sont possibles **du lundi au vendredi uniquement**
- Une seule réservation par jour par utilisateur
- Impossible d'annuler une réservation passée
- La création de comptes est réservée aux administrateurs

---

## 👤 Auteur

**COCO Mathis** — BTS SIO SLAM, ENC Bessières — Session 2026
