<?php
/**
 * Script pour créer le compte administrateur
 * 
 * ⚠️ IMPORTANT : Supprimez ce fichier après utilisation pour des raisons de sécurité !
 * 
 * Ce script crée uniquement l'utilisateur admin dans la table users existante.
 * 
 * Usage:
 * 1. Uploadez ce fichier sur votre serveur
 * 2. Accédez à: https://votre-site.com/create_admin.php
 * 3. Entrez le mot de passe pour l'admin
 * 4. Supprimez ce fichier immédiatement après
 */

// Charger la configuration
require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/src/utils/Security.php';

$message = '';
$error = '';
$success = false;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_password'])) {
    $adminPassword = $_POST['admin_password'];
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($adminPassword)) {
        $error = 'Le mot de passe ne peut pas être vide';
    } elseif (strlen($adminPassword) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères';
    } elseif ($adminPassword !== $confirmPassword) {
        $error = 'Les deux mots de passe ne correspondent pas';
    } else {
        try {
            $db = getDatabaseConnection();
            
            // Vérifier si l'utilisateur admin existe déjà
            $stmt = $db->prepare("SELECT id, login FROM users WHERE login = 'admin' LIMIT 1");
            $stmt->execute();
            $existingUser = $stmt->fetch();
            
            if ($existingUser) {
                // Mettre à jour le mot de passe si l'utilisateur existe déjà
                $hashedPassword = Security::hashPassword($adminPassword);
                $stmt = $db->prepare("UPDATE users SET mot_de_passe = ? WHERE login = 'admin'");
                $stmt->execute([$hashedPassword]);
                
                $success = true;
                $message = '✓ Mot de passe administrateur mis à jour avec succès !';
            } else {
                // Créer l'utilisateur admin
                $hashedPassword = Security::hashPassword($adminPassword);
                $stmt = $db->prepare("INSERT INTO users (login, mot_de_passe, role) VALUES ('admin', ?, 'admin')");
                $stmt->execute([$hashedPassword]);
                
                $success = true;
                $message = '✓ Compte administrateur créé avec succès !';
            }
        } catch (Exception $e) {
            $error = 'Erreur: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création du compte administrateur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        .container {
            background: rgba(26, 26, 26, 0.95);
            padding: 2.5rem;
            border-radius: 12px;
            border: 1px solid #404040;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #4a9eff;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }
        .warning {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            color: #ffc107;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .success {
            background: rgba(68, 255, 68, 0.1);
            border: 1px solid #44ff44;
            color: #44ff44;
            padding: 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        .error {
            background: rgba(255, 68, 68, 0.1);
            border: 1px solid #ff4444;
            color: #ff6666;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            color: #e0e0e0;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            background-color: #2d2d2d;
            border: 1px solid #404040;
            border-radius: 6px;
            color: #e0e0e0;
            font-size: 1rem;
        }
        input[type="password"]:focus {
            outline: none;
            border-color: #4a9eff;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #4a9eff;
            color: #1a1a1a;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #3a8eef;
        }
        .info {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #404040;
            color: #b0b0b0;
            font-size: 0.9rem;
        }
        .info strong {
            color: #ff4444;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>👤 Création du compte admin</h1>
        
        <div class="warning">
            ⚠️ <strong>ATTENTION :</strong> Supprimez ce fichier (create_admin.php) immédiatement après utilisation pour des raisons de sécurité !
        </div>
        
        <?php if ($success): ?>
            <div class="success">
                <?php echo htmlspecialchars($message); ?><br><br>
                <strong>Identifiants de connexion :</strong><br>
                • Login: <strong>admin</strong><br>
                • Mot de passe: (celui que vous venez d'entrer)
            </div>
            <div class="warning">
                <strong>Action requise :</strong> Supprimez ce fichier maintenant via FTP/SSH ou votre gestionnaire de fichiers.
            </div>
        <?php elseif ($error): ?>
            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="admin_password">Mot de passe administrateur *</label>
                <input type="password" id="admin_password" name="admin_password" required minlength="6" autofocus>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe *</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
            </div>
            
            <button type="submit">Créer le compte admin</button>
        </form>
        <?php endif; ?>
        
        <div class="info">
            <strong>Rappel :</strong> Ce fichier doit être supprimé après utilisation pour éviter tout accès non autorisé.
        </div>
    </div>
</body>
</html>

