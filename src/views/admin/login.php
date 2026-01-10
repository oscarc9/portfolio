<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Administration Portfolio</title>
    <?php
    // S'assurer que getBasePath() est disponible
    if (!function_exists('getBasePath')) {
        require_once __DIR__ . '/../../../config/paths.php';
    }
    $basePath = getBasePath();
    if (empty($basePath)) {
        $basePath = '/';
    } elseif (substr($basePath, -1) !== '/') {
        $basePath .= '/';
    }
    ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/main.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-header">
            <h1><i class="ri-lock-line"></i> Administration</h1>
            <p>Portfolio CMS</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo Security::sanitize($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="login">Nom d'utilisateur</label>
                <input type="text" id="login" name="login" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Se connecter</button>
        </form>
    </div>
</body>
</html>

