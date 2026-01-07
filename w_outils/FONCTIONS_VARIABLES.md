# 🔧 Fonctions et Variables du Portfolio CMS

## 📚 Table des Matières

1. [Variables Globales](#variables-globales)
2. [Fonctions de Base de Données](#fonctions-de-base-de-données)
3. [Fonctions de Sécurité](#fonctions-de-sécurité)
4. [Fonctions de Routage](#fonctions-de-routage)
5. [Fonctions de Session](#fonctions-de-session)
6. [Fonctions de Gestion des Pages](#fonctions-de-gestion-des-pages)
7. [Fonctions de Gestion des Médias](#fonctions-de-gestion-des-médias)
8. [Fonctions de Menu](#fonctions-de-menu)

---

## Variables Globales

### Configuration Base de Données

```php
// config/database.php

$DB_HOST = 'localhost';      // Adresse du serveur MySQL
$DB_NAME = 'portfolio';      // Nom de la base de données
$DB_USER = 'root';           // Nom d'utilisateur MySQL
$DB_PASS = '';               // Mot de passe MySQL
$DB_CHARSET = 'utf8mb4';     // Encodage des caractères
```

### Variables de Session

```php
// Variables stockées dans $_SESSION

$_SESSION['user_id']      // ID de l'utilisateur connecté (ex: 1)
$_SESSION['user_login']   // Login de l'utilisateur (ex: 'admin')
$_SESSION['logged_in']    // Booléen : true si connecté, false sinon
```

### Variables Utiles

```php
// Dans les contrôleurs et vues

$current_page    // Page actuellement affichée
$pages_list      // Liste de toutes les pages
$menu_items      // Éléments du menu à afficher
$error_message   // Message d'erreur à afficher
$success_message // Message de succès à afficher
```

---

## Fonctions de Base de Données

### Connexion

```php
// config/database.php

function getDatabaseConnection() {
    // Crée et retourne une connexion PDO à la base de données
    // Retourne : objet PDO
}
```

**Utilisation** :
```php
$db = getDatabaseConnection();
```

---

## Fonctions de Sécurité

### Hashage des Mots de Passe

```php
// src/utils/Security.php

function hashPassword($password) {
    // Hash un mot de passe avec bcrypt
    // Paramètre : $password (string) - mot de passe en clair
    // Retourne : string - mot de passe hashé
}
```

**Exemple** :
```php
$password = 'monMotDePasse123';
$hashed = hashPassword($password);
// Résultat : '$2y$10$...' (hash bcrypt)
```

### Vérification des Mots de Passe

```php
function verifyPassword($password, $hash) {
    // Vérifie si un mot de passe correspond à un hash
    // Paramètres :
    //   - $password (string) - mot de passe en clair
    //   - $hash (string) - mot de passe hashé stocké en BDD
    // Retourne : booléen (true si correspond, false sinon)
}
```

**Exemple** :
```php
if (verifyPassword('monMotDePasse123', $user->mot_de_passe)) {
    // Connexion réussie
}
```

### Nettoyage des Données (Input)

```php
function sanitizeInput($data) {
    // Nettoie les données entrées par l'utilisateur
    // Supprime les espaces, caractères dangereux
    // Paramètre : $data (string) - donnée à nettoyer
    // Retourne : string - donnée nettoyée
}
```

**Exemple** :
```php
$titre = sanitizeInput($_POST['titre']);
// "  Mon Titre  " devient "Mon Titre"
```

### Échappement pour XSS (Output)

```php
function escapeOutput($data) {
    // Échappe les caractères HTML pour éviter les attaques XSS
    // Paramètre : $data (string) - donnée à échapper
    // Retourne : string - donnée échappée
}
```

**Exemple** :
```php
echo escapeOutput($page->contenu);
// "<script>alert('hack')</script>" devient "&lt;script&gt;..."
```

### Validation des Fichiers Uploadés

```php
function validateUploadedFile($file, $allowed_types, $max_size) {
    // Vérifie qu'un fichier uploadé est valide
    // Paramètres :
    //   - $file (array) - $_FILES['nom_du_champ']
    //   - $allowed_types (array) - types autorisés ['image/jpeg', 'image/png']
    //   - $max_size (int) - taille max en octets (ex: 5MB = 5242880)
    // Retourne : array ['valid' => bool, 'error' => string]
}
```

**Exemple** :
```php
$result = validateUploadedFile(
    $_FILES['image'],
    ['image/jpeg', 'image/png'],
    5242880  // 5MB
);

if ($result['valid']) {
    // Fichier OK, peut être uploadé
} else {
    echo $result['error'];
}
```

---

## Fonctions de Routage

### Analyse d'une Route

```php
// src/utils/Router.php

function getCurrentRoute() {
    // Récupère la route actuelle depuis l'URL
    // Retourne : string - route (ex: 'mes-projets/epreuve-e5')
}
```

**Exemple** :
```php
$route = getCurrentRoute();
// Si URL = /mes-projets/epreuve-e5
// $route = 'mes-projets/epreuve-e5'
```

### Routage vers un Contrôleur

```php
function route($url) {
    // Analyse une URL et appelle le bon contrôleur
    // Paramètre : $url (string) - URL à analyser
    // Retourne : void (affiche directement la page)
}
```

---

## Fonctions de Session

### Démarrage de Session

```php
// src/utils/Session.php

function startSession() {
    // Démarre une session PHP de manière sécurisée
    // Retourne : void
}
```

### Vérification de Connexion

```php
function isLoggedIn() {
    // Vérifie si un utilisateur est connecté
    // Retourne : booléen (true si connecté, false sinon)
}
```

**Exemple** :
```php
if (!isLoggedIn()) {
    header('Location: /admin/login');
    exit;
}
```

### Destruction de Session

```php
function destroySession() {
    // Déconnecte l'utilisateur en détruisant la session
    // Retourne : void
}
```

---

## Fonctions de Gestion des Pages

### Récupérer Toutes les Pages

```php
// src/models/Page.php

function getAllPages() {
    // Récupère toutes les pages depuis la base de données
    // Retourne : array - liste d'objets Page
}
```

### Récupérer une Page par ID

```php
function getPageById($id) {
    // Récupère une page spécifique par son ID
    // Paramètre : $id (int) - ID de la page
    // Retourne : objet Page ou null si non trouvée
}
```

**Exemple** :
```php
$page = getPageById(5);
echo $page->titre;  // Affiche le titre
```

### Récupérer une Page par Slug

```php
function getPageBySlug($slug) {
    // Récupère une page par son slug (URL-friendly)
    // Paramètre : $slug (string) - slug de la page (ex: 'mon-profil')
    // Retourne : objet Page ou null si non trouvée
}
```

**Exemple** :
```php
$page = getPageBySlug('mon-profil');
```

### Créer une Page

```php
function createPage($titre, $contenu, $parent_id = null, $ordre = 0) {
    // Crée une nouvelle page
    // Paramètres :
    //   - $titre (string) - titre de la page
    //   - $contenu (string) - contenu de la page
    //   - $parent_id (int|null) - ID de la page parente (optionnel)
    //   - $ordre (int) - ordre d'affichage
    // Retourne : int - ID de la page créée
}
```

**Exemple** :
```php
$page_id = createPage(
    'Ma Nouvelle Page',
    'Contenu de la page...',
    null,  // Pas de parent
    1      // Ordre 1
);
```

### Modifier une Page

```php
function updatePage($id, $titre, $contenu, $parent_id = null, $ordre = 0) {
    // Modifie une page existante
    // Paramètres :
    //   - $id (int) - ID de la page à modifier
    //   - $titre, $contenu, $parent_id, $ordre (mêmes que createPage)
    // Retourne : booléen (true si succès, false sinon)
}
```

### Supprimer une Page

```php
function deletePage($id) {
    // Supprime une page
    // Paramètre : $id (int) - ID de la page à supprimer
    // Retourne : booléen (true si succès, false sinon)
}
```

---

## Fonctions de Gestion des Médias

### Récupérer les Médias d'une Page

```php
// src/models/Media.php

function getMediaByPageId($page_id) {
    // Récupère tous les médias associés à une page
    // Paramètre : $page_id (int) - ID de la page
    // Retourne : array - liste d'objets Media
}
```

**Exemple** :
```php
$medias = getMediaByPageId(5);
foreach ($medias as $media) {
    echo $media->fichier;  // Nom du fichier
}
```

### Uploader un Média

```php
function uploadMedia($file, $page_id, $type) {
    // Upload un fichier (image ou PDF) et l'associe à une page
    // Paramètres :
    //   - $file (array) - $_FILES['nom_du_champ']
    //   - $page_id (int) - ID de la page associée
    //   - $type (string) - 'image' ou 'pdf'
    // Retourne : array ['success' => bool, 'message' => string, 'file_id' => int]
}
```

**Exemple** :
```php
$result = uploadMedia($_FILES['image'], 5, 'image');
if ($result['success']) {
    echo "Image uploadée avec succès !";
}
```

### Supprimer un Média

```php
function deleteMedia($id) {
    // Supprime un média (fichier + enregistrement BDD)
    // Paramètre : $id (int) - ID du média
    // Retourne : booléen (true si succès, false sinon)
}
```

### Récupérer Toutes les Images de la Galerie

```php
function getAllGalleryImages() {
    // Récupère toutes les images pour la galerie "Ma passion"
    // Retourne : array - liste d'objets Media de type 'image'
}
```

---

## Fonctions de Menu

### Récupérer Tous les Menus

```php
// src/models/Menu.php

function getAllMenus() {
    // Récupère tous les éléments de menu
    // Retourne : array - liste d'objets Menu
}
```

### Récupérer les Menus Organisés (Hiérarchie)

```php
function getMenusHierarchy() {
    // Récupère les menus organisés par parent/enfant
    // Retourne : array - structure hiérarchique
}
```

**Exemple de structure retournée** :
```php
[
    [
        'id' => 1,
        'nom' => 'Accueil',
        'lien' => '/accueil',
        'children' => []
    ],
    [
        'id' => 2,
        'nom' => 'Mes projets',
        'lien' => '/mes-projets',
        'children' => [
            [
                'id' => 3,
                'nom' => 'Épreuve E5',
                'lien' => '/mes-projets/epreuve-e5',
                'children' => []
            ]
        ]
    ]
]
```

### Créer un Élément de Menu

```php
function createMenuItem($nom, $lien, $parent_id = null, $ordre = 0) {
    // Crée un nouvel élément de menu
    // Paramètres :
    //   - $nom (string) - nom affiché dans le menu
    //   - $lien (string) - lien/route (ex: '/accueil')
    //   - $parent_id (int|null) - ID du menu parent
    //   - $ordre (int) - ordre d'affichage
    // Retourne : int - ID du menu créé
}
```

### Supprimer un Élément de Menu

```php
function deleteMenuItem($id) {
    // Supprime un élément de menu
    // Paramètre : $id (int) - ID du menu
    // Retourne : booléen
}
```

---

## Fonctions d'Authentification

### Vérifier les Identifiants

```php
// src/models/User.php

function verifyCredentials($login, $password) {
    // Vérifie si un login/mot de passe est correct
    // Paramètres :
    //   - $login (string) - nom d'utilisateur
    //   - $password (string) - mot de passe en clair
    // Retourne : objet User ou null si incorrect
}
```

**Exemple** :
```php
$user = verifyCredentials('admin', 'monMotDePasse');
if ($user) {
    // Connexion réussie
    $_SESSION['user_id'] = $user->id;
    $_SESSION['logged_in'] = true;
}
```

### Récupérer un Utilisateur par ID

```php
function getUserById($id) {
    // Récupère un utilisateur par son ID
    // Paramètre : $id (int) - ID de l'utilisateur
    // Retourne : objet User ou null
}
```

---

## Schéma des Relations entre Fonctions

```
┌─────────────────────────────────────────────┐
│          FLUX D'UTILISATION TYPIQUE         │
└─────────────────────────────────────────────┘

1. VISITEUR ARRIVE SUR LE SITE
   │
   ├──► getCurrentRoute()          (Router)
   │
   ├──► getPageBySlug($slug)       (Page)
   │
   ├──► getMediaByPageId($id)      (Media)
   │
   └──► getMenusHierarchy()        (Menu)
        │
        ▼
   Affichage de la page

2. ADMIN SE CONNECTE
   │
   ├──► verifyCredentials()        (User)
   │
   ├──► startSession()             (Session)
   │
   └──► Redirection dashboard

3. ADMIN CRÉE UNE PAGE
   │
   ├──► sanitizeInput()            (Security)
   │
   ├──► createPage()               (Page)
   │
   └──► createMenuItem()           (Menu)

4. ADMIN UPLOADE UNE IMAGE
   │
   ├──► validateUploadedFile()     (Security)
   │
   ├──► uploadMedia()              (Media)
   │
   └──► Fichier sauvegardé
```

---

## Conventions de Nommage

### Variables
- **Singulier** pour un seul élément : `$page`, `$user`, `$media`
- **Pluriel** pour une liste : `$pages`, `$users`, `$medias`
- **Préfixe** pour les booléens : `$is_logged_in`, `$has_media`
- **Préfixe** pour les tableaux : `$menu_items`, `$page_list`

### Fonctions
- **get** pour récupérer : `getPageById()`, `getAllPages()`
- **create** pour créer : `createPage()`, `createMenuItem()`
- **update** pour modifier : `updatePage()`
- **delete** pour supprimer : `deletePage()`, `deleteMedia()`
- **verify** pour vérifier : `verifyCredentials()`, `verifyPassword()`
- **validate** pour valider : `validateUploadedFile()`

---

**Ce document te servira de référence pour comprendre chaque fonction et variable. Reviens-y quand tu codes !** 📖

