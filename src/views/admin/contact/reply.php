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

$pageTitle = $pageTitle ?? 'Répondre au message';
$basePath = $basePath ?? getBasePath();
$message = $message ?? null;
$error = $error ?? '';
$success = $success ?? '';

if (!$message) {
    header('Location: ' . $basePath . 'admin/contact');
    exit;
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
            <h1><i class="ri-reply-line"></i> Répondre au message</h1>
            <a href="<?php echo htmlspecialchars($basePath); ?>admin/contact" class="btn btn-secondary">
                <i class="ri-arrow-left-line"></i> Retour à la liste
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="ri-error-warning-line"></i> <?php echo Security::sanitize($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <i class="ri-check-line"></i> <?php echo Security::sanitize($success); ?>
            </div>
        <?php endif; ?>

        <div class="message-details">
            <h2><i class="ri-mail-line"></i> Message original</h2>
            <div class="detail-group">
                <label>De :</label>
                <p><?php echo Security::sanitize($message['nom'] ?? ''); ?> 
                   (<a href="mailto:<?php echo Security::sanitize($message['email'] ?? ''); ?>">
                       <?php echo Security::sanitize($message['email'] ?? ''); ?>
                   </a>)
                </p>
            </div>
            <div class="detail-group">
                <label>Date :</label>
                <p><?php echo htmlspecialchars($message['created_at'] ?? ''); ?></p>
            </div>
            <div class="detail-group">
                <label>Sujet :</label>
                <p><?php echo Security::sanitize($message['sujet'] ?? 'Sans sujet'); ?></p>
            </div>
            <div class="detail-group">
                <label>Message :</label>
                <div class="message-content">
                    <?php echo nl2br(Security::sanitize($message['message'] ?? '')); ?>
                </div>
            </div>
            
            <?php if (!empty($message['reponse'])): ?>
                <div class="detail-group">
                    <label>Réponse précédente :</label>
                    <div class="message-content previous-reply">
                        <?php echo nl2br(Security::sanitize($message['reponse'] ?? '')); ?>
                        <small>Envoyée le <?php echo htmlspecialchars($message['reponse_at'] ?? ''); ?></small>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="reponse">Votre réponse *</label>
                <textarea id="reponse" name="reponse" rows="10" required 
                          placeholder="Tapez votre réponse ici..."><?php echo isset($_POST['reponse']) ? htmlspecialchars($_POST['reponse']) : ''; ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn">
                    <i class="ri-send-plane-line"></i> Envoyer la réponse
                </button>
                <a href="<?php echo htmlspecialchars($basePath); ?>admin/contact" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</body>
</html>

