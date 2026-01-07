# 🏗️ Architecture du Portfolio CMS

## Vue d'Ensemble

```
┌─────────────────────────────────────────────────────────┐
│                    PORTFOLIO CMS                         │
└─────────────────────────────────────────────────────────┘
                          │
        ┌─────────────────┴─────────────────┐
        │                                   │
   ┌────▼────┐                        ┌────▼────┐
   │ FRONT   │                        │  BACK   │
   │ OFFICE  │                        │ OFFICE  │
   └────┬────┘                        └────┬────┘
        │                                   │
        │                                   │
   ┌────▼───────────────────────────────────▼────┐
   │         BASE DE DONNÉES (MySQL)              │
   │  ┌────────┐ ┌────────┐ ┌────────┐ ┌──────┐ │
   │  │ users  │ │ pages  │ │ media  │ │ menu │ │
   │  └────────┘ └────────┘ └────────┘ └──────┘ │
   └─────────────────────────────────────────────┘
```

---

## Structure des Dossiers

```
portfolio/
├── index.php              # Point d'entrée principal
├── .htaccess             # Configuration routage
│
├── config/
│   ├── database.php      # Connexion à la BDD
│   └── config.php        # Configuration générale
│
├── public/               # Fichiers accessibles publiquement
│   ├── css/
│   │   └── style.css     # Styles principaux (thème dark)
│   ├── js/
│   │   └── main.js       # JavaScript front-office
│   └── uploads/          # Images et PDF uploadés
│       ├── images/
│       └── pdf/
│
├── src/                  # Code PHP
│   ├── controllers/      # Contrôleurs (logique)
│   │   ├── PageController.php
│   │   ├── AuthController.php
│   │   └── MediaController.php
│   │
│   ├── models/           # Modèles (accès BDD)
│   │   ├── User.php
│   │   ├── Page.php
│   │   ├── Media.php
│   │   └── Menu.php
│   │
│   ├── views/            # Vues (affichage)
│   │   ├── front/        # Vues front-office
│   │   │   ├── header.php
│   │   │   ├── footer.php
│   │   │   ├── home.php
│   │   │   └── page.php
│   │   │
│   │   └── admin/        # Vues back-office
│   │       ├── login.php
│   │       ├── dashboard.php
│   │       └── pages/
│   │
│   └── utils/            # Utilitaires
│       ├── Router.php    # Gestion des routes
│       ├── Security.php  # Fonctions sécurité
│       └── Session.php   # Gestion sessions
│
└── database/
    └── schema.sql        # Structure de la base
```

---

## Flux de Navigation

### Front-Office (Visiteur)

```
Visiteur arrive sur le site
        │
        ▼
   index.php
        │
        ▼
   Router.php analyse l'URL
        │
        ├── /accueil ──────────► PageController::show('accueil')
        ├── /mon-profil ────────► PageController::show('mon-profil')
        ├── /mes-projets ───────► PageController::show('mes-projets')
        └── /contact ───────────► PageController::show('contact')
        │
        ▼
   Page.php récupère les données en BDD
        │
        ▼
   View (front/page.php) affiche la page
        │
        ▼
   Visiteur voit le contenu
```

### Back-Office (Admin)

```
Admin veut se connecter
        │
        ▼
   /admin/login
        │
        ▼
   AuthController::login()
        │
        ├── Vérifie login/mot de passe
        ├── Hashage vérifié
        └── Crée session
        │
        ▼
   /admin/dashboard
        │
        ▼
   Admin peut :
        ├── Gérer les pages
        ├── Uploader des médias
        ├── Organiser les menus
        └── Gérer la galerie
```

---

## Schéma de la Base de Données

```
┌─────────────┐
│    users    │
├─────────────┤
│ id (PK)     │
│ login       │
│ mot_de_passe│
│ role        │
└─────────────┘

┌─────────────┐
│    pages    │
├─────────────┤
│ id (PK)     │
│ titre       │
│ contenu     │
│ parent (FK) │──┐
│ ordre       │  │
│ slug        │  │ (auto-référence)
└─────────────┘  │
                 │
                 │
┌─────────────┐  │
│    media    │  │
├─────────────┤  │
│ id (PK)     │  │
│ type        │  │
│ fichier     │  │
│ page_id(FK) │──┼──► pages.id
└─────────────┘  │
                 │
┌─────────────┐  │
│    menu     │  │
├─────────────┤  │
│ id (PK)     │  │
│ nom         │  │
│ lien        │  │
│ parent (FK) │──┘
│ ordre       │
└─────────────┘
```

**Légende** :
- PK = Primary Key (clé primaire)
- FK = Foreign Key (clé étrangère)

---

## Système de Routage

### Principe

**URL demandée** : `/mes-projets/epreuve-e5`

**Traitement** :
1. `.htaccess` redirige vers `index.php?route=mes-projets/epreuve-e5`
2. `Router.php` analyse la route
3. `Router.php` trouve le contrôleur et la méthode correspondants
4. Le contrôleur exécute la logique
5. La vue est affichée

### Exemple de Code

```php
// .htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?route=$1 [QSA,L]

// Router.php
class Router {
    public function route($url) {
        // /mes-projets/epreuve-e5
        // → ['mes-projets', 'epreuve-e5']
        $parts = explode('/', $url);
        
        // Trouve la page correspondante en BDD
        // Affiche la page
    }
}
```

---

## Flux d'Authentification

```
┌─────────────┐
│ Page Login  │
└──────┬──────┘
       │
       │ Utilisateur entre login/password
       ▼
┌──────────────────┐
│ AuthController   │
│ ::login()        │
└──────┬───────────┘
       │
       ├──► Récupère user en BDD
       │
       ├──► Vérifie mot de passe (password_verify)
       │
       ├──► Si OK : Crée session
       │    └──► $_SESSION['user_id'] = $user->id
       │    └──► $_SESSION['logged_in'] = true
       │
       └──► Redirige vers /admin/dashboard
```

---

## Gestion des Médias (Upload)

```
Admin upload un fichier
        │
        ▼
┌──────────────────┐
│ MediaController  │
│ ::upload()       │
└──────┬───────────┘
       │
       ├──► Vérifie type MIME
       ├──► Vérifie extension
       ├──► Vérifie taille
       │
       ├──► Si OK :
       │    ├──► Génère nom unique
       │    ├──► Déplace fichier dans /public/uploads/
       │    └──► Enregistre en BDD (table media)
       │
       └──► Retourne succès/erreur
```

---

## Génération du Menu Dynamique

```
Page chargée
        │
        ▼
┌──────────────────┐
│ Menu::getAll()   │
└──────┬───────────┘
       │
       ├──► Récupère tous les menus en BDD
       │
       ├──► Organise par hiérarchie (parent/enfant)
       │
       └──► Génère HTML du menu
            │
            ▼
       Affichage dans header.php
```

---

## Variables et Fonctions Principales

### Variables Globales

```php
// config/config.php
$DB_HOST = 'localhost';
$DB_NAME = 'portfolio';
$DB_USER = 'root';
$DB_PASS = '';

// Session
$_SESSION['user_id']      // ID de l'utilisateur connecté
$_SESSION['logged_in']    // Booléen : est connecté ?
```

### Fonctions Utiles

```php
// Security.php
hashPassword($password)      // Hash un mot de passe
verifyPassword($password, $hash)  // Vérifie un mot de passe
sanitizeInput($data)         // Nettoie les données
escapeOutput($data)          // Échappe pour XSS

// Router.php
route($url)                  // Analyse et route une URL
getCurrentRoute()            // Retourne la route actuelle

// Session.php
startSession()               // Démarre une session
destroySession()             // Détruit une session
isLoggedIn()                 // Vérifie si connecté
```

---

## Conventions de Nommage

### Fichiers
- **Controllers** : `PageController.php`, `AuthController.php`
- **Models** : `Page.php`, `User.php`
- **Views** : `home.php`, `login.php`

### Variables
- **Base de données** : `$db`, `$pdo`
- **Pages** : `$page`, `$pages`
- **Utilisateurs** : `$user`, `$users`
- **Médias** : `$media`, `$medias`
- **Menus** : `$menu`, `$menus`

### Fonctions
- **Récupération** : `getAll()`, `getById($id)`
- **Création** : `create()`, `insert()`
- **Modification** : `update()`, `edit()`
- **Suppression** : `delete()`, `remove()`

---

## Points de Sécurité

```
┌─────────────────────────────────────┐
│         POINTS DE SÉCURITÉ          │
└─────────────────────────────────────┘

1. Hashage mots de passe
   └──► password_hash() / password_verify()

2. Requêtes préparées
   └──► $pdo->prepare() + bindParam()

3. Validation uploads
   └──► Vérifier type, taille, extension

4. Échappement XSS
   └──► htmlspecialchars() avant affichage

5. Protection CSRF
   └──► Tokens dans formulaires

6. Sessions sécurisées
   └──► session_regenerate_id()
```

---

**Cette architecture te donne une vision claire de comment tout s'articule. Tu peux revenir ici quand tu as besoin de comprendre un point précis !** 🎯

