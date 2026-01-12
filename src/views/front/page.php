<?php
// Vérifier que $pageData est défini
if (!isset($pageData) || empty($pageData)) {
    $pageData = ['titre' => 'Page non trouvée', 'contenu' => 'Contenu non disponible', 'id' => null];
}

// S'assurer que Security est chargé
if (!class_exists('Security')) {
    require_once __DIR__ . '/../../utils/Security.php';
}

// Récupérer les images associées à la page
$pageImages = [];
if (!empty($pageData['id'])) {
    try {
        if (!class_exists('Media')) {
            require_once __DIR__ . '/../../models/Media.php';
        }
        if (!isset($db)) {
            require_once __DIR__ . '/../../../config/db.php';
            $db = getDatabaseConnection();
        }
        $mediaModel = new Media($db);
        $pageImages = $mediaModel->findByPageId($pageData['id']);
    } catch (Exception $e) {
        error_log("Erreur récupération images page: " . $e->getMessage());
        $pageImages = [];
    }
}

// S'assurer que $basePath est défini
if (!isset($basePath)) {
    if (!function_exists('getBasePath')) {
        require_once __DIR__ . '/../../../config/paths.php';
    }
    $basePath = getBasePath();
}
?>
<main class="main-content">
    <section class="bts-sio" id="page-content">
        <header class="bts-sio__header">
            <h1><?php echo Security::sanitize($pageData['titre'] ?? 'Page sans titre'); ?></h1>
        </header>

        <?php if (!empty($pageImages)): ?>
            <div class="bts-sio__block">
                <div class="page-images-gallery">
                    <?php foreach ($pageImages as $image): ?>
                        <?php if (($image['type'] ?? '') === 'image'): ?>
                            <div class="page-image-item">
                                <img src="<?php echo htmlspecialchars($basePath); ?>public/uploads/<?php echo Security::sanitize($image['fichier'] ?? ''); ?>" 
                                     alt="<?php echo Security::sanitize($pageData['titre'] ?? ''); ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="bts-sio__block">
            <?php 
            $contenu = $pageData['contenu'] ?? '';
            if (empty(trim($contenu))) {
                echo '<p><em>Aucun contenu pour cette page.</em></p>';
            } else {
                // Afficher le contenu en préservant les sauts de ligne
                // Si le contenu contient du HTML, il sera échappé pour la sécurité
                echo nl2br(Security::sanitize($contenu));
            }
            ?>
        </div>
    </section>
</main>

