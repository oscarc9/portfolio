<?php
$pageTitle = 'Ma localisation';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include '../../src/views/includes/header.php';
include '../../src/views/includes/sidebar.php';
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
                    style="border:0; border-radius: 8px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Carte de localisation - 4 rue d'Upsal, Strasbourg">
                </iframe>
            </div>
            <p style="margin-top: 1rem; color: #b0b0b0;">
                <i class="ri-map-pin-line"></i> 4 rue d'Upsal, 67000 Strasbourg, France
            </p>
        </div>
    </section>
</main>

<?php include '../../src/views/includes/footer.php'; ?>

