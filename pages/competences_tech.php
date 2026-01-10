<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__);
$pageTitle = 'Compétences techniques';
$pageCSS = 'competences.css'; // CSS spécifique à cette page
include $rootPath . '/src/views/includes/header.php';
include $rootPath . '/src/views/includes/sidebar.php';
?>

<main class="main-content">
    <div class="competences-container">
        <header class="competences-header">
            <h1>Mes compétences techniques</h1>
            <p>
                Technologies et outils que j'utilise pour développer des solutions web modernes et sécurisées.
            </p>
        </header>

        <div class="competences-grid">
            <!-- Développement web -->
            <div class="competence-card web">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-code-s-slash-line"></i>
                    </div>
                    <h3 class="competence-card-title">Développement web</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">HTML5</span>
                        <span class="skill-desc">Structure sémantique</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">CSS3</span>
                        <span class="skill-desc">Responsive & Dark mode</span>
                    </li>
                </ul>
            </div>

            <!-- Back-end -->
            <div class="competence-card backend">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-server-line"></i>
                    </div>
                    <h3 class="competence-card-title">Back-end</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">PHP</span>
                        <span class="skill-desc">Procédural & POO</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Routes</span>
                        <span class="skill-desc">.htaccess & URLs propres</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">PDO</span>
                        <span class="skill-desc">Requêtes préparées</span>
                    </li>
                </ul>
            </div>

            <!-- Base de données -->
            <div class="competence-card database">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-database-2-line"></i>
                    </div>
                    <h3 class="competence-card-title">Base de données</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">MySQL</span>
                        <span class="skill-desc">phpMyAdmin</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Conception</span>
                        <span class="skill-desc">Tables & relations</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">CRUD</span>
                        <span class="skill-desc">Opérations complètes</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Import/Export</span>
                        <span class="skill-desc">Fichiers .sql</span>
                    </li>
                </ul>
            </div>

            <!-- CMS / Back-office -->
            <div class="competence-card cms">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-settings-3-line"></i>
                    </div>
                    <h3 class="competence-card-title">CMS & Back-office</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">CMS from scratch</span>
                        <span class="skill-desc">Développement complet</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Pages dynamiques</span>
                        <span class="skill-desc">Gestion de contenu</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Upload médias</span>
                        <span class="skill-desc">Images & PDF</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Interface admin</span>
                        <span class="skill-desc">Back-office</span>
                    </li>
                </ul>
            </div>

            <!-- Sécurité -->
            <div class="competence-card security">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-shield-check-line"></i>
                    </div>
                    <h3 class="competence-card-title">Sécurité</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">Hashage</span>
                        <span class="skill-desc">bcrypt / password_hash</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Protection SQL</span>
                        <span class="skill-desc">Anti-injection</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Validation</span>
                        <span class="skill-desc">Formulaires sécurisés</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Sessions</span>
                        <span class="skill-desc">Gestion utilisateurs</span>
                    </li>
                </ul>
            </div>

            <!-- Outils -->
            <div class="competence-card tools">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-tools-line"></i>
                    </div>
                    <h3 class="competence-card-title">Outils & Environnement</h3>
                </div>
                <ul class="competence-skills">
                    <li class="competence-skill">
                        <span class="skill-name">VS Code</span>
                        <span class="skill-desc">Éditeur de code</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">XAMPP</span>
                        <span class="skill-desc">Serveur local</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Git</span>
                        <span class="skill-desc">Versionning</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">FileZilla</span>
                        <span class="skill-desc">Transfert FTP</span>
                    </li>
                    <li class="competence-skill">
                        <span class="skill-name">Hébergement</span>
                        <span class="skill-desc">Déploiement web</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php 
$rootPath = dirname(__DIR__);
include $rootPath . '/src/views/includes/footer.php'; 
?>
