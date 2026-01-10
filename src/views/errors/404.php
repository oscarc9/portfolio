<?php
$pageTitle = 'Page non trouvée';
$pageCSS = 'bts.css';
include '../../src/views/includes/header.php';
include '../../src/views/includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio">
        <header class="bts-sio__header">
            <h1>404 - Page non trouvée</h1>
            <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
        </header>
        <div class="bts-sio__block">
            <p>
                <a href="<?php echo $basePath; ?>accueil" class="download-link">
                    <i class="ri-home-line"></i> Retour à l'accueil
                </a>
            </p>
        </div>
    </section>
</main>

<?php include '../../src/views/includes/footer.php'; ?>

