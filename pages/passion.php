<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__);
$pageTitle = 'Ma passion';
$pageCSS = 'bts.css'; // CSS spécifique à cette page
include $rootPath . '/src/views/includes/header.php';
include $rootPath . '/src/views/includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio">
        <header class="bts-sio__header">
            <h1>Ma passion : la cybersécurité</h1>
            <p>
                Au fil des deux années de BTS SIO, j'ai progressivement choisi de m'orienter vers la <strong>cybersécurité</strong>.
                Cette passion est née de ma curiosité pour comprendre comment attaquer et protéger les systèmes et les données.
            </p>
        </header>

        <div class="bts-sio__block">
            <h2>Mon parcours vers la cybersécurité</h2>
            <p>
                En commençant le BTS SIO option SLAM, j'étais principalement intéressé par le développement web et les applications.
                Cependant, au cours de ma formation, j'ai découvert que ce qui me passionnait vraiment, c'était comprendre les failles de sécurité,
                utiliser différents outils et techniques pour attaquer et protéger les systèmes et les données.
            </p>
            <p>
                La cybersécurité combine plusieurs aspects qui m'attirent : l'analyse technique, la résolution de problèmes complexes,
                et surtout, l'importance de protéger les données et les systèmes contre les menaces.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Voici ce sur quoi je me suis penché cette année et ce que j'ai appris</h2>
            
            <!-- Galerie de photos défilante dynamique depuis BDD -->
            <?php
            try {
                // S'assurer que $basePath est défini
                if (!isset($basePath)) {
                    if (!function_exists('getBasePath')) {
                        require_once __DIR__ . '/../config/paths.php';
                    }
                    $basePath = getBasePath();
                }
                
                require_once __DIR__ . '/../config/db.php';
                require_once __DIR__ . '/../src/utils/GalleryHelper.php';
                $db = getDatabaseConnection();

                // Génération dynamique depuis la BDD
                $galleryHtml = GalleryHelper::generateCarousel($db, $basePath);

                // Si la BDD ne contient pas d'images, on bascule sur le fallback statique
                if (empty($galleryHtml) || strpos($galleryHtml, 'gallery-empty') !== false) {
                    throw new Exception('Galerie vide, fallback statique');
                }

                echo $galleryHtml;
            } catch (Exception $e) {
                // Fallback vers carousel statique si erreur BDD ou galerie vide
                error_log("Erreur galerie: " . $e->getMessage());
            ?>
            <div class="carousel-wrapper">
                <!-- Radio buttons cachés pour la navigation -->
                <input type="radio" name="carousel" id="carousel-1" class="carousel-radio" checked>
                <input type="radio" name="carousel" id="carousel-2" class="carousel-radio">
                <input type="radio" name="carousel" id="carousel-3" class="carousel-radio">
                <input type="radio" name="carousel" id="carousel-4" class="carousel-radio">
                <input type="radio" name="carousel" id="carousel-5" class="carousel-radio">
                <input type="radio" name="carousel" id="carousel-6" class="carousel-radio">
                
                <!-- Flèche précédente - visible selon le slide actif -->
                <label for="carousel-6" class="carousel-arrow carousel-prev carousel-prev-1">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                <label for="carousel-1" class="carousel-arrow carousel-prev carousel-prev-2">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                <label for="carousel-2" class="carousel-arrow carousel-prev carousel-prev-3">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                <label for="carousel-3" class="carousel-arrow carousel-prev carousel-prev-4">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                <label for="carousel-4" class="carousel-arrow carousel-prev carousel-prev-5">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                <label for="carousel-5" class="carousel-arrow carousel-prev carousel-prev-6">
                    <i class="ri-arrow-left-s-line"></i>
                </label>
                
                <!-- Container du carousel -->
                <div class="carousel-container">
                    <div class="carousel-track">
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/buffer.jpg" alt="Buffer Overflow">
                            <div class="slide-caption">
                                <h3>Buffer Overflow</h3>
                                <p>Analyse et exploitation des débordements de tampon</p>
                            </div>
                        </div>
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/hydra.jpg" alt="Hydra">
                            <div class="slide-caption">
                                <h3>Hydra</h3>
                                <p>Test de force brute et attaques par dictionnaire</p>
                            </div>
                        </div>
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/script.jpg" alt="Scripts de sécurité">
                            <div class="slide-caption">
                                <h3>Scripts de sécurité</h3>
                                <p>Automatisation des tests de sécurité</p>
                            </div>
                        </div>
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/hack.jpg" alt="Hack phishing">
                            <div class="slide-caption">
                                <h3>Hack phishing</h3>
                                <p>Attaque par phishing et récupération de mots de passe</p>
                            </div>
                        </div>
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/etudiant.jpg" alt="Etudiant">
                            <div class="slide-caption">
                                <h3>Salon de l'etudiant (Paris)</h3>
                                <p>Salon de l'etudiant à Paris</p>
                            </div>
                        </div>
                        <div class="carousel-slide">
                            <img src="<?php echo $basePath; ?>gallery/esme.jpg" alt="esme">
                            <div class="slide-caption">
                                <h3>Presentation ecole ESME</h3>
                                <p>Presentation ecole esme pour bachelor(Paris)</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Flèche suivante - visible selon le slide actif -->
                <label for="carousel-2" class="carousel-arrow carousel-next carousel-next-1">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
                <label for="carousel-3" class="carousel-arrow carousel-next carousel-next-2">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
                <label for="carousel-4" class="carousel-arrow carousel-next carousel-next-3">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
                <label for="carousel-5" class="carousel-arrow carousel-next carousel-next-4">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
                <label for="carousel-6" class="carousel-arrow carousel-next carousel-next-5">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
                <label for="carousel-1" class="carousel-arrow carousel-next carousel-next-6">
                    <i class="ri-arrow-right-s-line"></i>
                </label>
            </div>
            <?php
            }
            ?>
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
            <h2>Mon objectif</h2>
            <p>
                Mon objectif est de continuer après le BTS dans une voie orientée <strong>cybersécurité</strong> :
                défense, analyse de sécurité, audit ou pentest selon les opportunités qui se présenteront.
                Je souhaite approfondir mes connaissances et contribuer à rendre le monde numérique plus sûr.
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Autres centres d'intérêt</h2>
            <div class="autres-passions-grid">
                <div class="passion-item-wrapper">
                    <div class="passion-card">
                        <img src="<?php echo $basePath; ?>gallery/gym.jpg" alt="Sport">
                        <h3>Sport</h3>
                    </div>
                    <p>j'aime faire du sport, je m'entraine depuis plusieurs années maintenant et cela ma grandement aider à rester concentré et motivé dans de nombreux domaines.</p>
                </div>
                <div class="passion-item-wrapper">
                    <div class="passion-card">
                        <img src="<?php echo $basePath; ?>gallery/projetjs.jpg" alt="Développement web">
                        <h3>Développement web</h3>
                    </div>
                    <p>j'ai longement apprécié faire du développement web lors de mon BTS, tester des bibliothèques, des apis et des frameworks.</p>
                </div>
                <div class="passion-item-wrapper">
                    <div class="passion-card">
                        <img src="<?php echo $basePath; ?>gallery/dev_perso.jpg" alt="Développement personnel">
                        <h3>Développement personnel</h3>
                    </div>
                    <p>j'aime beaucoup lire des livres, regarder des videos ou des podcast sur des sujets qui me plaisent.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php 
$rootPath = dirname(__DIR__);
include $rootPath . '/src/views/includes/footer.php'; 
?>
