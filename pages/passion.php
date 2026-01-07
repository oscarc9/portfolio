<?php
$pageTitle = 'Ma passion';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include '../src/views/includes/header.php';
include '../src/views/includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio">
        <header class="bts-sio__header">
            <h1>Ma passion : la cybersécurité</h1>
            <p>
                Au fil des deux années de BTS SIO, j'ai progressivement choisi de m'orienter vers la <strong>cybersécurité</strong>.
                Cette passion est née de ma curiosité pour comprendre comment protéger les systèmes et les données.
            </p>
        </header>

        <div class="bts-sio__block">
            <h2>Mon parcours vers la cybersécurité</h2>
            <p>
                En commençant le BTS SIO option SLAM, j'étais principalement intéressé par le développement web et les applications.
                Cependant, au cours de ma formation, j'ai découvert que ce qui me passionnait vraiment, c'était comprendre les failles de sécurité,
                analyser les vulnérabilités et mettre en place des solutions pour protéger les systèmes informatiques.
            </p>
            <p>
                La cybersécurité combine plusieurs aspects qui m'attirent : l'analyse technique, la résolution de problèmes complexes,
                et surtout, l'importance de protéger les données et les systèmes contre les menaces.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Ce qui m'attire dans la cybersécurité</h2>
            <div class="passion-grid">
                <div class="passion-item">
                    <div class="passion-image-placeholder">
                        <i class="ri-shield-check-line"></i>
                        <p>Image à ajouter</p>
                    </div>
                    <h3>Protection des systèmes</h3>
                    <p>
                        Comprendre comment sécuriser les applications et les infrastructures pour protéger les données sensibles.
                    </p>
                </div>

                <div class="passion-item">
                    <div class="passion-image-placeholder">
                        <i class="ri-bug-line"></i>
                        <p>Image à ajouter</p>
                    </div>
                    <h3>Analyse des vulnérabilités</h3>
                    <p>
                        Identifier et analyser les failles de sécurité pour mieux comprendre comment les corriger et les prévenir.
                    </p>
                </div>

                <div class="passion-item">
                    <div class="passion-image-placeholder">
                        <i class="ri-search-line"></i>
                        <p>Image à ajouter</p>
                    </div>
                    <h3>Investigation et forensique</h3>
                    <p>
                        Analyser les incidents de sécurité, tracer les attaques et comprendre les méthodes utilisées par les cybercriminels.
                    </p>
                </div>

                <div class="passion-item">
                    <div class="passion-image-placeholder">
                        <i class="ri-lock-password-line"></i>
                        <p>Image à ajouter</p>
                    </div>
                    <h3>Cryptographie et authentification</h3>
                    <p>
                        Étudier les mécanismes de chiffrement et les systèmes d'authentification pour sécuriser les communications.
                    </p>
                </div>
            </div>
        </div>

        <div class="bts-sio__block">
            <h2>Mes projets et apprentissages</h2>
            <p>
                Au cours de ma formation, j'ai intégré la sécurité dans mes projets de développement :
            </p>
            <ul>
                <li>Implémentation de l'hashage des mots de passe (bcrypt)</li>
                <li>Protection contre les injections SQL avec PDO</li>
                <li>Validation et sécurisation des formulaires</li>
                <li>Gestion sécurisée des sessions utilisateur</li>
            </ul>
        </div>

        <div class="bts-sio__block">
            <h2>Galerie</h2>
            <div class="passion-gallery">
                <div class="gallery-item">
                    <div class="gallery-image-placeholder">
                        <i class="ri-image-line"></i>
                        <p>Image 1 à ajouter</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image-placeholder">
                        <i class="ri-image-line"></i>
                        <p>Image 2 à ajouter</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image-placeholder">
                        <i class="ri-image-line"></i>
                        <p>Image 3 à ajouter</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <div class="gallery-image-placeholder">
                        <i class="ri-image-line"></i>
                        <p>Image 4 à ajouter</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bts-sio__block">
            <h2>Mon objectif</h2>
            <p>
                Mon objectif est de continuer après le BTS dans une voie orientée <strong>cybersécurité</strong> :
                défense, analyse de sécurité, audit ou pentest selon les opportunités qui se présenteront.
                Je souhaite approfondir mes connaissances et contribuer à rendre le monde numérique plus sûr.
            </p>
        </div>
    </section>
</main>

<?php include '../src/views/includes/footer.php'; ?>

