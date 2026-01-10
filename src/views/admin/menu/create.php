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

$pageTitle = 'Créer un élément de menu';
$basePath = getBasePath();
$error = $error ?? '';
$allPages = $allPages ?? [];
$allMenuItems = $allMenuItems ?? [];
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
            <h1><i class="ri-add-line"></i> Créer un élément de menu</h1>
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
                       value="<?php echo isset($_POST['nom']) ? Security::sanitize($_POST['nom']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="lien">Lien (optionnel)</label>
                <input type="text" id="lien" name="lien" 
                       value="<?php echo isset($_POST['lien']) ? Security::sanitize($_POST['lien']) : ''; ?>"
                       placeholder="/exemple ou https://exemple.com">
                <div class="help-text">Laissez vide si vous associez une page</div>
            </div>

            <div class="form-group">
                <label for="page_id">Page associée (optionnel)</label>
                <select id="page_id" name="page_id">
                    <option value="">Aucune</option>
                    <?php if (!empty($allPages)): ?>
                        <?php foreach ($allPages as $p): ?>
                            <option value="<?php echo (int)($p['id'] ?? 0); ?>" 
                                    <?php echo (isset($_POST['page_id']) && $_POST['page_id'] == ($p['id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($p['titre'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="parent_id">Élément parent (optionnel)</label>
                <select id="parent_id" name="parent_id">
                    <option value="">Aucun (élément racine)</option>
                    <?php if (!empty($allMenuItems)): ?>
                        <?php foreach ($allMenuItems as $item): ?>
                            <option value="<?php echo (int)($item['id'] ?? 0); ?>" 
                                    <?php echo (isset($_POST['parent_id']) && $_POST['parent_id'] == ($item['id'] ?? 0)) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($item['nom'] ?? ''); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Créer l'élément
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

