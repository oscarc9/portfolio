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

$pageTitle = 'Uploader un média';
$basePath = getBasePath();
$success = $success ?? '';
$error = $error ?? '';
$pages = $pages ?? [];
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
            <h1><i class="ri-upload-line"></i> Uploader un média</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/media" class="btn btn-secondary">
                <i class="ri-arrow-left-line"></i> Retour à la liste
            </a>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo Security::sanitize($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <?php echo Security::sanitize($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="type">Type de média *</label>
                <select id="type" name="type" required>
                    <option value="image">Image</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>

            <div class="form-group">
                <label for="file">Fichier *</label>
                <input type="file" id="file" name="file" required accept="image/*,application/pdf">
                <div class="help-text">
                    Formats acceptés : JPG, PNG, GIF, WEBP (images) ou PDF<br>
                    Taille maximum : 5 MB
                </div>
            </div>

            <div class="form-group">
                <label for="page_id">Page associée (optionnel)</label>
                <select id="page_id" name="page_id">
                    <option value="">Aucune</option>
                    <?php if (!empty($pages)): ?>
                        <?php foreach ($pages as $p): ?>
                            <option value="<?php echo (int)($p['id'] ?? 0); ?>">
                                <?php echo Security::sanitize($p['titre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-upload-line"></i> Uploader
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/media" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

