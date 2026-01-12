<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Charger les dépendances nécessaires
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

if (!class_exists('Security')) {
    require_once __DIR__ . '/../../src/utils/Security.php';
}

// Vérifier l'authentification
Security::requireAdmin();

$pageTitle = 'Tableau de bord';

// Initialiser les variables si elles ne sont pas définies
if (!isset($pagesCount)) {
    $pagesCount = 0;
}
if (!isset($mediaCount)) {
    $mediaCount = 0;
}
if (!isset($menuCount)) {
    $menuCount = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Administration Portfolio</title>
    <?php $basePath = getBasePath(); ?>
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/main.css">
    <link rel="stylesheet" href="<?php echo htmlspecialchars($basePath); ?>public/css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="ri-dashboard-line"></i> Tableau de bord</h1>
            <div>
                <span class="user-info">Connecté en tant que : <strong><?php echo Security::sanitize($_SESSION['user_login'] ?? 'Admin'); ?></strong></span>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/logout" class="logout-link">
                    <i class="ri-logout-box-line"></i> Déconnexion
                </a>
            </div>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <h3>Pages</h3>
                <p class="number"><?php echo (int)$pagesCount; ?></p>
            </div>
            <div class="stat-card">
                <h3>Médias</h3>
                <p class="number"><?php echo (int)$mediaCount; ?></p>
            </div>
            <div class="stat-card">
                <h3>Éléments de menu</h3>
                <p class="number"><?php echo (int)$menuCount; ?></p>
            </div>
        </div>

        <div class="admin-menu">
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/pages" class="admin-menu-item">
                <i class="ri-file-text-line"></i>
                <span>Gérer les pages</span>
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/media" class="admin-menu-item">
                <i class="ri-image-line"></i>
                <span>Gérer les médias</span>
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/menu" class="admin-menu-item">
                <i class="ri-menu-line"></i>
                <span>Gérer le menu</span>
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/contact" class="admin-menu-item">
                <i class="ri-mail-line"></i>
                <span>Messages de contact</span>
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>accueil" class="admin-menu-item">
                <i class="ri-home-line"></i>
                <span>Voir le site</span>
            </a>
        </div>
    </div>
</body>
</html>

