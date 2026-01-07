<?php
$pageTitle = 'Soft skills';
$pageCSS = 'competences.css'; // CSS spécifique à cette page
include '../src/views/includes/header.php';
include '../src/views/includes/sidebar.php';
?>

<main class="main-content">
    <div class="competences-container">
        <header class="competences-header">
            <h1>Mes soft skills</h1>
            <p>
                Compétences comportementales et relationnelles qui me permettent de travailler efficacement en équipe et de mener des projets à bien.
            </p>
        </header>

        <div class="competences-grid">
            <!-- Communication -->
            <div class="competence-card communication">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-message-3-line"></i>
                    </div>
                    <h3 class="competence-card-title">Communication</h3>
                </div>
                <div class="soft-skill-content">
                    <p class="soft-skill-desc">
                        Échanges clairs et adaptés au contexte, que ce soit avec des clients, des collègues ou des utilisateurs finaux.
                    </p>
                </div>
            </div>

            <!-- Organisation -->
            <div class="competence-card organisation">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <h3 class="competence-card-title">Organisation</h3>
                </div>
                <div class="soft-skill-content">
                    <p class="soft-skill-desc">
                        Planification et priorisation des tâches pour optimiser l'efficacité et respecter les délais.
                    </p>
                </div>
            </div>

            <!-- Autonomie -->
            <div class="competence-card autonomie">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-user-star-line"></i>
                    </div>
                    <h3 class="competence-card-title">Autonomie</h3>
                </div>
                <div class="soft-skill-content">
                    <p class="soft-skill-desc">
                        Capacité à avancer seul et à résoudre des problèmes de manière indépendante tout en sachant demander de l'aide quand nécessaire.
                    </p>
                </div>
            </div>

            <!-- Persévérance -->
            <div class="competence-card perseverance">
                <div class="competence-card-header">
                    <div class="competence-card-icon">
                        <i class="ri-flashlight-line"></i>
                    </div>
                    <h3 class="competence-card-title">Persévérance</h3>
                </div>
                <div class="soft-skill-content">
                    <p class="soft-skill-desc">
                        Capacité à mener un projet de développement à terme malgré les difficultés techniques ou les obstacles rencontrés.
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../src/views/includes/footer.php'; ?>

