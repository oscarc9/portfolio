<?php
$pageTitle = 'Modifier une page';
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
            <h1><i class="ri-edit-line"></i> Modifier la page</h1>
            <a href="<?php echo getBasePath(); ?>admin/pages" class="btn btn-secondary">
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
                       value="<?php echo Security::sanitize($page['titre']); ?>">
            </div>

            <div class="form-group">
                <label>Slug</label>
                <div class="slug-info">
                    <code><?php echo Security::sanitize($page['slug']); ?></code>
                    <p>Le slug ne peut pas être modifié après création</p>
                </div>
            </div>

            <div class="form-group">
                <label for="parent_id">Page parente (optionnel)</label>
                <select id="parent_id" name="parent_id">
                    <option value="">Aucune (page racine)</option>
                    <?php foreach ($allPages as $p): ?>
                        <?php if ($p['id'] != $page['id']): ?>
                            <option value="<?php echo $p['id']; ?>" 
                                    <?php echo ($page['parent_id'] == $p['id']) ? 'selected' : ''; ?>>
                                <?php echo Security::sanitize($p['titre']); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ordre">Ordre d'affichage</label>
                <input type="number" id="ordre" name="ordre" value="<?php echo $page['ordre']; ?>" min="0">
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea id="contenu" name="contenu" rows="15" class="large"><?php echo htmlspecialchars($page['contenu']); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-save-line"></i> Enregistrer les modifications
                </button>
                <a href="<?php echo getBasePath(); ?>admin/pages" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

