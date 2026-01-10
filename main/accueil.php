<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__);
$pageTitle = 'Accueil';
$pageCSS = 'accueil.css'; // CSS spécifique à cette page
include $rootPath . '/src/views/includes/header.php';
include $rootPath . '/src/views/includes/sidebar.php';
?>

<!-- Contenu principal -->
<main class="main-content">
    <div class="accueil-container">
        <header class="accueil-header">
            <h1>Bienvenue sur mon Portfolio</h1>
            <p>
                Je m'appelle <strong>Oscar</strong>, étudiant en <strong>BTS SIO option SLAM</strong>.
                Au fil de la formation, je me suis orienté vers ce qui m'attire le plus : la <strong>cybersécurité</strong>.
            </p>
        </header>

        <div class="social-links">
            <a href="https://www.linkedin.com/in/oscar-sineux-6398b4256/" target="_blank" rel="noopener noreferrer" class="social-link linkedin" title="LinkedIn">
                <i class="ri-linkedin-fill"></i>
            </a>
            <a href="mailto:oscarsineux95@gmail.com" class="social-link mail" title="Email">
                <i class="ri-mail-fill"></i>
            </a>
            <a href="https://github.com/oscarc9" target="_blank" rel="noopener noreferrer" class="social-link github" title="GitHub">
                <i class="ri-github-fill"></i>
            </a>
        </div>
    </div>
</main>

<?php 
$rootPath = dirname(__DIR__);
include $rootPath . '/src/views/includes/footer.php'; 
?>
