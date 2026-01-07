<?php
// S'assure que $basePath est défini
if (!isset($basePath)) {
    if (!function_exists('getBasePath')) {
        require_once __DIR__ . '/../../../config/paths.php';
    }
    $basePath = getBasePath();
}
?>
<!-- Bouton menu mobile (toujours visible) -->
<label for="menu-toggle" class="menu-icon"><i class="bx bx-menu"></i></label>
<input type="checkbox" id="menu-toggle">

<!-- Navigation latérale gauche -->
<nav class="sidebar">
    <div class="logo">
        <a href="<?php echo $basePath; ?>main/accueil.php">
            <img src="<?php echo $basePath; ?>gallery/oscar.jpeg" alt="Ma photo" class="profile-photo">
            <span class="logo-text">Mon Portfolio</span>
        </a>
    </div>
    
    <ul class="navbar">
        <li><a href="<?php echo $basePath; ?>main/accueil.php"><i class="ri-home-line"></i> Accueil</a></li>
        <li><a href="<?php echo $basePath; ?>pages/BTS.php"><i class="ri-book-line"></i> Présentation BTS SIO</a></li>
        
        <li><a href="<?php echo $basePath; ?>pages/mon_profil.php"><i class="ri-user-line"></i> Mon profil</a></li>
        
        <li class="has-submenu">
            <input type="checkbox" id="submenu-competences" class="submenu-toggle">
            <label for="submenu-competences"><i class="ri-tools-line"></i> Mes compétences <i class="ri-arrow-down-s-line arrow"></i></label>
            <ul class="submenu">
                <li><a href="<?php echo $basePath; ?>pages/competences_tech.php">Compétences techniques</a></li>
                <li><a href="<?php echo $basePath; ?>pages/soft_skills.php">Soft skills</a></li>
            </ul>
        </li>
        
        <li class="has-submenu">
            <input type="checkbox" id="submenu-projets" class="submenu-toggle">
            <label for="submenu-projets"><i class="ri-folder-line"></i> Mes projets <i class="ri-arrow-down-s-line arrow"></i></label>
            <ul class="submenu">
                <li><a href="<?php echo $basePath; ?>pages/e5.php"><i class="ri-file-list-3-line"></i> Épreuve E5</a></li>
                <li><a href="<?php echo $basePath; ?>pages/e6.php"><i class="ri-code-box-line"></i> Épreuve E6</a></li>
                <li><a href="<?php echo $basePath; ?>pages/autres-projets.php">Autres projets</a></li>
            </ul>
        </li>
        
        <li><a href="<?php echo $basePath; ?>pages/passion.php"><i class="ri-image-line"></i> Ma passion</a></li>
        <li><a href="<?php echo $basePath; ?>pages/contact.php"><i class="ri-mail-line"></i> Contact</a></li>
    </ul>

    <div class="nav-footer">
        <a href="<?php echo $basePath; ?>admin/login.php" class="admin-link"><i class="ri-lock-line"></i> Administration</a>
    </div>
</nav>

