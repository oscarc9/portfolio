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

$pageTitle = 'Créer une page';
$basePath = getBasePath();
$error = $error ?? '';
$allPages = $allPages ?? [];
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
            <h1><i class="ri-add-line"></i> Créer une page</h1>
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
                       value="<?php echo isset($_POST['titre']) ? Security::sanitize($_POST['titre']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="parent_id">Page parente (optionnel)</label>
                <select id="parent_id" name="parent_id">
                    <option value="">Aucune (page racine)</option>
                    <?php if (!empty($allPages)): ?>
                        <?php foreach ($allPages as $p): ?>
                            <option value="<?php echo (int)($p['id'] ?? 0); ?>" 
                                    <?php echo (isset($_POST['parent_id']) && $_POST['parent_id'] == ($p['id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($p['titre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ordre">Ordre d'affichage</label>
                <input type="number" id="ordre" name="ordre" value="<?php echo isset($_POST['ordre']) ? (int)$_POST['ordre'] : 0; ?>" min="0">
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea id="contenu" name="contenu" rows="15" class="large"><?php echo isset($_POST['contenu']) ? htmlspecialchars($_POST['contenu']) : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Créer la page
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

