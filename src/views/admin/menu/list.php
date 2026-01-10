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

$pageTitle = 'Gestion du menu';
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
$basePath = getBasePath();

// Fonction récursive pour afficher le menu hiérarchique
function displayMenuItems($items, $level = 0, $basePath) {
    if (empty($items)) return;
    
    foreach ($items as $item) {
        $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
        echo '<tr>';
        echo '<td>' . $indent . Security::sanitize($item['nom'] ?? '') . '</td>';
        echo '<td>' . (($item['lien'] ?? '') ? Security::sanitize($item['lien']) : '-') . '</td>';
        echo '<td>' . (int)($item['ordre'] ?? 0) . '</td>';
        echo '<td>';
        echo '<div class="actions">';
        echo '<a href="' . htmlspecialchars($basePath) . 'admin/menu/edit?id=' . (int)($item['id'] ?? 0) . '" class="btn btn-small">';
        echo '<i class="ri-edit-line"></i> Modifier</a>';
        echo '<a href="' . htmlspecialchars($basePath) . 'admin/menu/delete?id=' . (int)($item['id'] ?? 0) . '" ';
        echo 'class="btn btn-small btn-danger" ';
        echo 'onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet élément ?\');">';
        echo '<i class="ri-delete-bin-line"></i> Supprimer</a>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        
        if (!empty($item['children'])) {
            displayMenuItems($item['children'], $level + 1, $basePath);
        }
    }
}
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
            <h1><i class="ri-menu-line"></i> Gestion du menu</h1>
            <div class="form-actions">
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/dashboard" class="btn btn-small">
                    <i class="ri-arrow-left-line"></i> Retour
                </a>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu/create" class="btn">
                    <i class="ri-add-line"></i> Ajouter un élément
                </a>
            </div>
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
                    <th>Nom</th>
                    <th>Lien</th>
                    <th>Ordre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($menuItems)): ?>
                    <tr>
                        <td colspan="4">
                            Aucun élément de menu. <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu/create">Ajouter le premier élément</a>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php displayMenuItems($menuItems, 0, $basePath); ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

