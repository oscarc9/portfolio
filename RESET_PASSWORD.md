# Réinitialisation du mot de passe administrateur

## Méthode 1 : Via SQL (Recommandé)

1. Connectez-vous à votre base de données MySQL (phpMyAdmin, MySQL Workbench, ou ligne de commande)
2. Exécutez le fichier `database/reset_admin_password.sql`
3. Le mot de passe sera réinitialisé à : **admin123**

### Commandes SQL directes :

```sql
UPDATE `users` 
SET `mot_de_passe` = '$2y$10$i4R0ry8Xq.qXKszYQm5NBOFfn.AgcWjfS9kn91SLvEB7Nvn1/1meK' 
WHERE `login` = 'admin';
```

## Méthode 2 : Via script PHP (Local uniquement)

Si vous êtes en local avec XAMPP :

```bash
php reset_admin_password.php admin123
```

Pour définir un autre mot de passe :

```bash
php reset_admin_password.php votre_nouveau_mot_de_passe
```

## Identifiants par défaut

- **Login** : `admin`
- **Mot de passe** : `admin123`

⚠️ **Important** : Changez ce mot de passe après votre première connexion !

## Générer un nouveau hash de mot de passe

Si vous voulez créer un hash pour un autre mot de passe :

```bash
php -r "echo password_hash('votre_mot_de_passe', PASSWORD_BCRYPT);"
```

Puis utilisez ce hash dans la requête SQL UPDATE.

