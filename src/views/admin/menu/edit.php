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

$pageTitle = 'Modifier un élément de menu';
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
            <h1><i class="ri-edit-line"></i> Modifier l'élément de menu</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu" class="btn btn-secondary">
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
                <label for="nom">Nom *</label>
                <input type="text" id="nom" name="nom" required 
                       value="<?php echo Security::sanitize($menuItem['nom'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="page_id">Page associée (optionnel)</label>
                <select id="page_id" name="page_id">
                    <option value="">Aucune</option>
                    <?php if (!empty($allPages)): ?>
                        <?php foreach ($allPages as $p): ?>
                            <option value="<?php echo (int)($p['id'] ?? 0); ?>" 
                                    <?php echo (($menuItem['page_id'] ?? null) == ($p['id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($p['titre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Enregistrer les modifications
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

