# Portfolio CMS - Documentation

## Installation

### 1. Base de données

1. Créer la base de données `portfolio` dans MySQL/phpMyAdmin
2. Exécuter le script SQL : `database/schema.sql`
   - Ce script crée les 4 tables nécessaires
   - Crée un compte admin par défaut (login: `admin`, mot de passe: `admin123`)

### 2. Configuration

Vérifier les paramètres de connexion dans `config/db.php` :
- `$DB_HOST` : adresse du serveur (généralement `localhost`)
- `$DB_NAME` : nom de la base de données (`portfolio`)
- `$DB_USER` : utilisateur MySQL
- `$DB_PASS` : mot de passe MySQL

### 3. Permissions

S'assurer que le dossier `public/uploads/` est accessible en écriture pour les uploads de fichiers.

## Utilisation

### Accès au back-office

1. Aller sur `/admin/login`
2. Se connecter avec :
   - Login : `admin`
   - Mot de passe : `admin123`
3. **Important** : Changer le mot de passe après la première connexion !

### Fonctionnalités du back-office

#### Gestion des pages (`/admin/pages`)
- Créer, modifier, supprimer des pages
- Organiser les pages en hiérarchie (pages parentes/enfants)
- Définir l'ordre d'affichage

#### Gestion des médias (`/admin/media`)
- Uploader des images (JPG, PNG, GIF, WEBP)
- Uploader des PDF
- Taille maximum : 5 MB
- Supprimer des médias

#### Gestion du menu (`/admin/menu`)
- Créer des éléments de menu
- Organiser en hiérarchie (menus et sous-menus)
- Associer à des pages ou définir des liens personnalisés
- Définir l'ordre d'affichage

### Migration des pages statiques

Pour convertir les pages statiques existantes en entrées BDD :

```bash
php database/migrate_static_pages.php
```

## Structure des URLs

Le système utilise des URLs propres grâce au routage :

- `/accueil` → Page d'accueil
- `/bts` → Présentation BTS
- `/mon-profil` → Mon profil
- `/epreuve-e5` → Épreuve E5
- `/epreuve-e6` → Épreuve E6
- `/contact` → Contact
- `/admin` → Dashboard admin
- `/admin/pages` → Gestion des pages
- `/admin/media` → Gestion des médias
- `/admin/menu` → Gestion du menu

Les pages créées dynamiquement sont accessibles via leur slug : `/mon-slug`

## Sécurité

- Mots de passe hashés avec bcrypt
- Requêtes préparées PDO (protection SQL injection)
- Protection XSS (htmlspecialchars)
- Validation stricte des fichiers uploadés
- Sessions sécurisées
- Protection des routes admin

## Fonctionnalités

### Front-office
- Affichage dynamique des pages depuis la BDD
- Menu généré automatiquement depuis la BDD
- Galerie photos dynamique (page Passion)
- Formulaire de contact (envoi email + stockage BDD)
- Intégration Google Maps

### Back-office
- CRUD complet pour pages, médias et menu
- Interface d'administration intuitive
- Upload sécurisé de fichiers
- Gestion hiérarchique du menu

## Notes importantes

- Les pages statiques existantes continuent de fonctionner
- Le système fonctionne en mode dégradé si la BDD n'est pas disponible
- Les fichiers uploadés sont stockés dans `public/uploads/`
- Les messages de contact sont stockés dans la table `contact_messages` (créée automatiquement)

