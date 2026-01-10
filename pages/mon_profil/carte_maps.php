<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__, 2);
$pageTitle = 'Ma localisation';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include $rootPath . '/src/views/includes/header.php';
include $rootPath . '/src/views/includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio" id="carte">
        <header class="bts-sio__header">
            <h1>Ma localisation</h1>
            <p>
                Je me trouve à <strong>Strasbourg, 4 rue d'Upsal</strong>.
            </p>
        </header>

        <div class="bts-sio__block">
            <h2>Carte de localisation</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps?q=4+rue+d%27Upsal,+67000+Strasbourg&output=embed"
                    width="100%" 
                    height="450" 
                    class="map-iframe" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Carte de localisation - 4 rue d'Upsal, Strasbourg">
                </iframe>
            </div>
            <p class="map-address">
                <i class="ri-map-pin-line"></i> 4 rue d'Upsal, 67000 Strasbourg, France
            </p>
        </div>
    </section>
</main>

<?php 
$rootPath = dirname(__DIR__, 2);
include $rootPath . '/src/views/includes/footer.php'; 
?>

