<?php
$pageTitle = 'Modifier un élément de menu';
require_once __DIR__ . '/../../../config/paths.php';
require_once __DIR__ . '/../../../config/db.php';
require_once __DIR__ . '/../../../src/utils/Security.php';

Security::requireAdmin();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Administration</title>
    <link rel="stylesheet" href="<?php echo getBasePath(); ?>public/css/main.css">
    <link rel="stylesheet" href="<?php echo getBasePath(); ?>public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="ri-edit-line"></i> Modifier l'élément de menu</h1>
            <a href="<?php echo getBasePath(); ?>admin/menu" class="btn btn-secondary">
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
                       value="<?php echo Security::sanitize($menuItem['nom']); ?>">
            </div>

            <div class="form-group">
                <label for="lien">Lien (optionnel)</label>
                <input type="text" id="lien" name="lien" 
                       value="<?php echo Security::sanitize($menuItem['lien'] ?? ''); ?>"
                       placeholder="/exemple ou https://exemple.com">
                <div class="help-text">Laissez vide si vous associez une page</div>
            </div>

            <div class="form-group">
                <label for="page_id">Page associée (optionnel)</label>
                <select id="page_id" name="page_id">
                    <option value="">Aucune</option>
                    <?php foreach ($allPages as $p): ?>
                        <option value="<?php echo $p['id']; ?>" 
                                <?php echo ($menuItem['page_id'] == $p['id']) ? 'selected' : ''; ?>>
                            <?php echo Security::sanitize($p['titre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="parent_id">Élément parent (optionnel)</label>
                <select id="parent_id" name="parent_id">
                    <option value="">Aucun (élément racine)</option>
                    <?php foreach ($allMenuItems as $item): ?>
                        <?php if ($item['id'] != $menuItem['id']): ?>
                            <option value="<?php echo $item['id']; ?>" 
                                    <?php echo ($menuItem['parent_id'] == $item['id']) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($item['nom']); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ordre">Ordre d'affichage</label>
                <input type="number" id="ordre" name="ordre" value="<?php echo $menuItem['ordre']; ?>" min="0">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Enregistrer les modifications
                </button>
                <a href="<?php echo getBasePath(); ?>admin/menu" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

