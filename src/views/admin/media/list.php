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

$pageTitle = 'Gestion des médias';
$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';
$type = $_GET['type'] ?? null;
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
            <h1><i class="ri-image-line"></i> Gestion des médias</h1>
            <div class="form-actions">
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/dashboard" class="btn btn-small">
                    <i class="ri-arrow-left-line"></i> Retour
                </a>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/media/upload" class="btn">
                    <i class="ri-upload-line"></i> Uploader un fichier
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

        <div class="filters">
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/media" class="<?php echo $type === null ? 'active' : ''; ?>">
                Tous
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/media?type=image" class="<?php echo $type === 'image' ? 'active' : ''; ?>">
                Images
            </a>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/media?type=pdf" class="<?php echo $type === 'pdf' ? 'active' : ''; ?>">
                PDF
            </a>
        </div>

        <?php if (empty($media)): ?>
            <div class="empty-state">
                <i class="ri-image-line"></i>
                Aucun média trouvé. <a href="<?php echo htmlspecialchars($basePath); ?>admin/media/upload">Uploader le premier média</a>
            </div>
        <?php else: ?>
            <div class="media-grid">
                <?php foreach ($media as $m): ?>
                    <div class="media-item">
                        <?php if (($m['type'] ?? '') === 'image'): ?>
                            <img src="<?php echo htmlspecialchars($basePath); ?>public/uploads/<?php echo Security::sanitize($m['fichier'] ?? ''); ?>" 
                                 alt="<?php echo Security::sanitize($m['fichier'] ?? ''); ?>">
                        <?php else: ?>
                            <div class="media-pdf-placeholder">
                                <i class="ri-file-pdf-line"></i>
                            </div>
                        <?php endif; ?>
                        <div class="media-info">
                            <p class="media-name"><?php echo Security::sanitize($m['fichier'] ?? ''); ?></p>
                            <p class="media-type"><?php echo strtoupper($m['type'] ?? ''); ?></p>
                            <div class="media-actions">
                                <a href="<?php echo htmlspecialchars($basePath); ?>public/uploads/<?php echo Security::sanitize($m['fichier'] ?? ''); ?>" 
                                   target="_blank" class="btn btn-small">
                                    <i class="ri-eye-line"></i> Voir
                                </a>
                                <a href="<?php echo htmlspecialchars($basePath); ?>admin/media/delete?id=<?php echo (int)($m['id'] ?? 0); ?>" 
                                   class="btn btn-small btn-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?');">
                                    <i class="ri-delete-bin-line"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

