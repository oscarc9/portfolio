<?php
// Charger Security si pas déjà chargé
if (!class_exists('Security')) {
    require_once __DIR__ . '/../../utils/Security.php';
}

// S'assurer que $basePath est défini
if (!isset($basePath)) {
    if (!function_exists('getBasePath')) {
        require_once __DIR__ . '/../../../config/paths.php';
    }
    $basePath = getBasePath();
}

// S'assurer que basePath se termine par un slash
if (!empty($basePath) && substr($basePath, -1) !== '/') {
    $basePath .= '/';
}

// Si basePath est vide, utiliser "/"
if (empty($basePath)) {
    $basePath = '/';
}

$pageTitle = 'Contact';
$pageCSS = 'bts.css';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <section class="bts-sio" id="contact">
        <header class="bts-sio__header">
            <h1>Contact</h1>
            <p>
                N'hésitez pas à me contacter pour toute question ou opportunité.
            </p>
        </header>

        <?php if (!empty($success)): ?>
            <div class="bts-sio__block contact-success">
                <p>
                    <?php echo Security::sanitize($success); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bts-sio__block contact-error">
                <p>
                    <?php echo Security::sanitize($error); ?>
                </p>
            </div>
        <?php endif; ?>

        <div class="bts-sio__block">
            <h2>Coordonnées</h2>
            <p>
                <strong>Email :</strong> <a href="mailto:oscarsineux95@gmail.com" class="contact-link">oscarsineux95@gmail.com</a>
            </p>
            <p>
                <strong>LinkedIn :</strong> <a href="https://www.linkedin.com/in/oscar-sineux-6398b4256/" target="_blank" class="contact-link">Profil LinkedIn</a>
            </p>
            <p>
                <strong>GitHub :</strong> <a href="https://github.com/oscarc9" target="_blank" class="contact-link">github.com/oscarc9</a>
            </p>
        </div>

        <div class="bts-sio__block">
            <h2>Formulaire de contact</h2>
            <form method="POST" action="" class="contact-form">
                <div class="contact-form-group">
                    <label for="nom">
                        Nom * <span class="required">*</span>
                    </label>
                    <input type="text" id="nom" name="nom" required
                           value="<?php echo isset($_POST['nom']) ? Security::sanitize($_POST['nom']) : ''; ?>">
                </div>

                <div class="contact-form-group">
                    <label for="email">
                        Email * <span class="required">*</span>
                    </label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? Security::sanitize($_POST['email']) : ''; ?>">
                </div>

                <div class="contact-form-group">
                    <label for="sujet">Sujet</label>
                    <input type="text" id="sujet" name="sujet"
                           value="<?php echo isset($_POST['sujet']) ? Security::sanitize($_POST['sujet']) : ''; ?>">
                </div>

                <div class="contact-form-group">
                    <label for="message">
                        Message * <span class="required">*</span>
                    </label>
                    <textarea id="message" name="message" required rows="8"><?php echo isset($_POST['message']) ? Security::sanitize($_POST['message']) : ''; ?></textarea>
                </div>

                <button type="submit" class="contact-submit-btn">
                    <i class="ri-send-plane-line"></i> Envoyer le message
                </button>
            </form>
        </div>
    </section>
</main>

<?php 
include __DIR__ . '/../includes/footer.php'; 
?>

