<?php
$pageTitle = 'Présentation du BTS SIO';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include '../src/views/includes/header.php';
include '../src/views/includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio">
        <header class="bts-sio__header">
            <h1>Présentation du BTS SIO</h1>
            <p>
                Le BTS SIO (Services Informatiques aux Organisations) est un diplôme Bac +2.
                Il forme des techniciens capables de créer, gérer et sécuriser des solutions informatiques en entreprise.
            </p>
        </header>

        <article class="bts-sio__block">
            <h2>Objectifs de la formation</h2>
            <ul>
                <li>Comprendre le fonctionnement d'un système informatique en entreprise</li>
                <li>Développer et maintenir des applications</li>
                <li>Gérer des bases de données</li>
                <li>Mettre en place des solutions réseau et assurer la disponibilité des services</li>
                <li>Appliquer des bonnes pratiques de sécurité (accès, données, protection)</li>
                <li>Travailler en mode projet et communiquer avec des utilisateurs</li>
            </ul>
        </article>

        <article class="bts-sio__block">
            <h2>Les deux options</h2>

            <div class="bts-sio__options">
                <div class="bts-sio__option">
                    <img src="<?php echo $basePath; ?>gallery/sisr.jpg" alt="Option SISR" class="bts-sio__option-image">
                    <h3>Option SISR</h3>
                    <p>
                        L'option SISR est orientée systèmes et réseaux : serveurs, réseau, maintenance, supervision, sécurité.
                    </p>
                    <p class="bts-sio__mini-title">Exemples de métiers :</p>
                    <ul>
                        <li>Technicien systèmes et réseaux</li>
                        <li>Administrateur systèmes / réseaux (junior)</li>
                        <li>Technicien support</li>
                    </ul>
                </div>

                <div class="bts-sio__option">
                    <img src="<?php echo $basePath; ?>gallery/slam.jpeg" alt="Option SLAM" class="bts-sio__option-image">
                    <h3>Option SLAM</h3>
                    <p>
                        L'option SLAM est orientée développement : sites web, applications, bases de données, logique métier,
                        et sécurité côté application.
                    </p>
                    <p class="bts-sio__mini-title">Exemples de métiers :</p>
                    <ul>
                        <li>Développeur web</li>
                        <li>Développeur applicatif (junior)</li>
                        <li>Analyste / développeur</li>
                    </ul>
                </div>
            </div>
        </article>

        <article class="bts-sio__block">
            <h2>Épreuves importantes</h2>
            <ul>
                <li><strong>E5 :</strong> portfolio + missions + présentation/démonstration du travail réalisé</li>
                <li><strong>E6 (SLAM) :</strong> deux réalisations informatiques + oral technique</li>
            </ul>
        </article>

        <article class="bts-sio__block">
            <h2>Après le BTS</h2>
            <ul>
                <li>Entrer dans la vie professionnelle</li>
                <li>Ou continuer en licence pro / bachelor / école spécialisée (dev, réseau, cybersécurité)</li>
            </ul>
        </article>
    </section>
</main>

<?php include '../src/views/includes/footer.php'; ?>
