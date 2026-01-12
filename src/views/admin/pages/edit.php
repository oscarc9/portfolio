<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charger les dépendances nécessaires
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../../config/paths.php';
}

if (!class_exists('Security')) {
    require_once __DIR__ . '/../../../src/utils/Security.php';
}

// Vérifier l'authentification
Security::requireAdmin();

$pageTitle = 'Modifier une page';
$basePath = getBasePath();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Administration</title>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/main.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="ri-edit-line"></i> Modifier la page</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages" class="btn btn-secondary">
                <i class="ri-arrow-left-line"></i> Retour à la liste
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error">
                <?php echo Security::sanitize($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="titre">Titre *</label>
                <input type="text" id="titre" name="titre" required 
                       value="<?php echo Security::sanitize($page['titre'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Slug</label>
                <div class="slug-info">
                    <code><?php echo Security::sanitize($page['slug'] ?? ''); ?></code>
                    <p>Le slug ne peut pas être modifié après création</p>
                </div>
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea id="contenu" name="contenu" rows="15" class="large"><?php echo htmlspecialchars($page['contenu'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Enregistrer les modifications
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

