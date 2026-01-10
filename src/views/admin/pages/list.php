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

$pageTitle = 'Gestion des pages';
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
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
            <h1><i class="ri-file-text-line"></i> Gestion des pages</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/dashboard" class="btn btn-small">
                <i class="ri-arrow-left-line"></i> Retour
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages/create" class="btn">
                <i class="ri-add-line"></i> Créer une page
            </a>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo Security::sanitize($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo Security::sanitize($error); ?>
            </div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pages)): ?>
                    <tr>
                        <td colspan="4">
                            Aucune page trouvée. <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages/create">Créer la première page</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?php echo (int)$page['id']; ?></td>
                            <td><?php echo Security::sanitize($page['titre'] ?? ''); ?></td>
                            <td><code><?php echo Security::sanitize($page['slug'] ?? ''); ?></code></td>
                            <td>
                                <div class="actions">
                                    <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages/edit?id=<?php echo (int)$page['id']; ?>" class="btn btn-small">
                                        <i class="ri-edit-line"></i> Modifier
                                    </a>
                                    <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages/delete?id=<?php echo (int)$page['id']; ?>" 
                                       class="btn btn-small btn-danger"
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette page ?');">
                                        <i class="ri-delete-bin-line"></i> Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

