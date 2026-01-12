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

$pageTitle = $pageTitle ?? 'Messages de contact';
$basePath = $basePath ?? getBasePath();
$messages = $messages ?? [];
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
            <h1><i class="ri-mail-line"></i> Messages de contact</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/dashboard" class="btn btn-small">
                <i class="ri-arrow-left-line"></i> Retour
            </a>
        </div>

        <?php if (empty($messages)): ?>
            <div class="alert alert-info">
                <i class="ri-information-line"></i> Aucun message pour le moment.
            </div>
        <?php else: ?>
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Sujet</th>
                            <th>Message</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($msg['created_at'] ?? ''); ?></td>
                            <td><?php echo Security::sanitize($msg['nom'] ?? ''); ?></td>
                            <td><?php echo Security::sanitize($msg['email'] ?? ''); ?></td>
                            <td><?php echo Security::sanitize($msg['sujet'] ?? 'Sans sujet'); ?></td>
                            <td class="message-preview">
                                <?php echo Security::sanitize(substr($msg['message'] ?? '', 0, 100)); ?>
                                <?php if (strlen($msg['message'] ?? '') > 100): ?>...<?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($msg['reponse'])): ?>
                                    <span class="badge badge-success">
                                        <i class="ri-check-line"></i> Répondu
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-warning">
                                        <i class="ri-time-line"></i> En attente
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo htmlspecialchars($basePath); ?>admin/contact/reply?id=<?php echo (int)($msg['id'] ?? 0); ?>" 
                                   class="btn btn-small">
                                    <i class="ri-reply-line"></i> Répondre
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

