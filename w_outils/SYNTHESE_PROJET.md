# 📋 Synthèse du Projet Portfolio CMS

## 🎯 Objectif Principal

Créer un **site web Portfolio** pour présenter ton parcours BTS SIO, tes compétences et tes projets. C'est un projet **obligatoire** pour l'épreuve E5.

⚠️ **Important** : Si le Portfolio n'est pas fonctionnel, pénalité de -10 points sur 20.

---

## 🏗️ Architecture du Projet

### Structure Générale

```
Portfolio CMS
├── Front-office (partie publique)
│   └── Les visiteurs voient ton contenu
│
└── Back-office (partie admin)
    └── Toi, tu gères le contenu (pages, images, menus)
```

### Les Deux Parties du Site

**Front-office** = Ce que tout le monde voit
- Pages publiques (Accueil, Profil, Projets, etc.)
- Menu de navigation
- Galerie photos
- Formulaire de contact

**Back-office** = Ton espace d'administration
- Connexion sécurisée
- Gestion des pages (créer, modifier, supprimer)
- Gestion des images et PDF
- Organisation des menus

---

## 📑 Pages Obligatoires

### Menu Principal (en haut)

1. **Accueil** - Page d'entrée du site
2. **Présentation du BTS SIO** - Explication de la formation
3. **Mon profil**
   - Présentation personnelle
   - Carte Google Maps (ta localisation)
4. **Mes compétences**
   - Compétences techniques
   - Soft skills
5. **Mes projets**
   - **Épreuve E5**
     - Présentation E5
     - Mes missions E5
     - Tableau de synthèse
     - PowerPoint soutenance
     - Ma veille
     - Rapports de mission (1ère et 2ème année)
   - **Épreuve E6**
     - Présentation E6
     - Mes 2 réalisations
   - Autres projets (optionnel)
6. **Ma passion** - Galerie photos défilante
7. **Contact**
   - Coordonnées
   - Carte Google Maps
   - Formulaire de contact (envoi email)

### Menu Pied de Page

- **Mentions légales** (obligatoire - RGPD)
- Politique de confidentialité (optionnel)

---

## ⚙️ Fonctionnalités Techniques à Développer

### 1. Système de Routage
**Objectif** : Avoir des URLs propres et lisibles

❌ **Mauvais** : `page.php?id=12`  
✅ **Bon** : `/accueil`, `/mes-projets`, `/epreuve-e5/mes-missions`

**Comment** : Utiliser un fichier `.htaccess` (si Apache) pour réécrire les URLs.

---

### 2. Authentification
**Objectif** : Se connecter au back-office de manière sécurisée

- Page de connexion
- Vérification du mot de passe (hashé avec bcrypt ou Argon2)
- Gestion de session (rester connecté)
- Déconnexion sécurisée

---

### 3. Gestion des Contenus (Back-office)

**Ce que tu dois pouvoir faire** :
- ✅ Créer une nouvelle page
- ✅ Modifier une page existante
- ✅ Supprimer une page
- ✅ Ajouter du texte (éditeur simple)
- ✅ Uploader des images
- ✅ Uploader des PDF
- ✅ Organiser les menus (ajouter, supprimer, hiérarchiser)
- ✅ Gérer la galerie photos (ajout/suppression)

---

### 4. Front-office (Affichage)

**Ce que les visiteurs voient** :
- Pages générées dynamiquement depuis la base de données
- Menu automatique généré depuis la base
- Galerie photos en diaporama
- Formulaire de contact fonctionnel
- Cartes Google Maps (Profil + Contact)

---

### 5. Base de Données

**Tables minimales à créer** :

#### Table `users`
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Identifiant unique |
| login | VARCHAR | Nom d'utilisateur |
| mot_de_passe | VARCHAR | Mot de passe hashé |
| rôle | VARCHAR | Rôle (admin, etc.) |

#### Table `pages`
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Identifiant unique |
| titre | VARCHAR | Titre de la page |
| contenu | TEXT | Contenu de la page |
| parent | INT | ID de la page parente (pour hiérarchie) |
| ordre | INT | Ordre d'affichage |

#### Table `media`
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Identifiant unique |
| type | VARCHAR | Type (image/pdf) |
| fichier | VARCHAR | Nom du fichier |
| page_id | INT | ID de la page associée |

#### Table `menu`
| Colonne | Type | Description |
|---------|------|-------------|
| id | INT | Identifiant unique |
| nom | VARCHAR | Nom du menu |
| lien | VARCHAR | Lien/route |
| parent | INT | ID du menu parent |
| ordre | INT | Ordre d'affichage |

**Relations** :
- Une page peut avoir plusieurs médias
- Le menu reflète la hiérarchie des pages

---

### 6. Sécurité

**Points importants** :
- ✅ Validation des formulaires (côté serveur ET client)
- ✅ Hashage des mots de passe (bcrypt/Argon2)
- ✅ Vérification des fichiers uploadés (type, taille, extension)
- ✅ Protection contre injections SQL (requêtes préparées)
- ✅ Protection contre XSS (échappement des données)
- ✅ Déconnexion sécurisée (destruction de session)

---

## 📅 Planning sur 10 Semaines

| Semaine | Travail à Faire |
|---------|----------------|
| **1** | Présentation projet, préparation environnement, début conception BDD |
| **2** | Schéma BDD complet (MCD/MLD), arborescence menus, début HTML/CSS |
| **3** | Maquettes graphiques, charte graphique, templates (header, footer) |
| **4** | Système de routage, connexion BDD, affichage pages dynamiques |
| **5** | Authentification (connexion, session), premier back-office |
| **6** | Gestion pages (CRUD), génération menu automatique |
| **7** | Gestion médias (images, PDF), galerie photo défilante |
| **8** | Formulaire contact + email, intégration Google Maps |
| **9** | Tests, corrections, sécurité renforcée |
| **10** | Finalisation, préparation soutenance, démonstration |

---

## 📦 Livrables à Rendre

1. **Code source complet** (tous les fichiers, organisés et commentés)
2. **Base de données exportée** (fichier .sql)
3. **Site fonctionnel** (démonstration en local)
4. **Plan de démonstration** (script de test pour la soutenance)
5. **PowerPoint** (5 diapos max : contexte, architecture, fonctionnalités, démo, retour expérience)

---

## 🎤 Soutenance (15 minutes)

1. **Présentation PowerPoint** (3 min)
   - Contexte, architecture, fonctionnalités, retour expérience

2. **Démonstration technique** (9 min)
   - Connexion/déconnexion
   - Back-office
   - Création/modification page
   - Ajout média
   - Menu dynamique
   - Galerie photo
   - Formulaire contact
   - Google Maps
   - Navigation pages obligatoires

3. **Retour d'expérience** (3 min)
   - Difficultés rencontrées
   - Solutions apportées
   - Compétences acquises
   - Améliorations possibles

---

## 💡 Points Importants à Retenir

✅ **À faire** :
- Code from scratch (pas de WordPress/Joomla)
- Utiliser des librairies/frameworks si justifiés
- Projet individuel
- Respecter le CDCF (cahier des charges)

❌ **À éviter** :
- Utiliser un CMS existant
- Copier du code sans comprendre
- Oublier la sécurité
- Ne pas respecter les menus obligatoires

---

## 🎨 Préférences de Développement

- **Thème** : Dark, sobre
- **Code** : Simple, adapté au niveau
- **Documentation** : Phrases humanisées, schémas clairs
- **Variables** : Noms cohérents, pas de mélange

---

## ❓ Questions à Te Poser

1. Quelle technologie backend ? (PHP recommandé pour BTS SIO)
2. Quelle base de données ? (MySQL/MariaDB)
3. Framework CSS ? (Bootstrap, Tailwind, ou CSS pur)
4. JavaScript ? (Vanilla JS ou framework léger)

---

**Tu es prêt à commencer ! N'hésite pas à poser des questions, je suis là pour t'aider à comprendre chaque étape.** 🚀

