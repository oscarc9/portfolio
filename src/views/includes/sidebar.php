<?php
// S'assure que $basePath est défini
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

// Charger le menu depuis la base de données
$menuItems = [];
try {
    if (function_exists('getDatabaseConnection')) {
        require_once __DIR__ . '/../../../config/db.php';
        require_once __DIR__ . '/../../../src/models/Menu.php';
        $db = getDatabaseConnection();
        $menuModel = new Menu($db);
        $menuItems = $menuModel->getHierarchical();
    }
} catch (Exception $e) {
    // En cas d'erreur, utiliser le menu statique par défaut
    error_log("Erreur chargement menu: " . $e->getMessage());
    $menuItems = [];
}

// Fonction récursive pour afficher le menu
function renderMenuItems($items, $basePath, $level = 0) {
    if (empty($items)) return;
    
    foreach ($items as $item) {
        // Déterminer l'URL
        $url = $item['lien'] ?? '';
        if (empty($url) && !empty($item['page_id'])) {
            try {
                require_once __DIR__ . '/../../../src/models/Page.php';
                if (!isset($db)) {
                    require_once __DIR__ . '/../../../config/db.php';
                    $db = getDatabaseConnection();
                }
                $pageModel = new Page($db);
                $page = $pageModel->findById($item['page_id']);
                if ($page) {
                    $url = $basePath . $page['slug'];
                }
            } catch (Exception $e) {
                error_log("Erreur génération URL menu: " . $e->getMessage());
            }
        }
        if (empty($url)) {
            $url = '#';
        } elseif (strpos($url, 'http') !== 0 && strpos($url, 'mailto:') !== 0 && $url[0] !== '/') {
            $url = $basePath . ltrim($url, '/');
        }
        
        // Afficher l'élément
        if (!empty($item['children'])) {
            // Élément avec sous-menu
            $submenuId = 'submenu-' . $item['id'];
            echo '<li class="has-submenu">';
            echo '<input type="checkbox" id="' . $submenuId . '" class="submenu-toggle">';
            echo '<label for="' . $submenuId . '">';
            echo htmlspecialchars($item['nom']) . ' <i class="ri-arrow-down-s-line arrow"></i>';
            echo '</label>';
            echo '<ul class="submenu">';
            renderMenuItems($item['children'], $basePath, $level + 1);
            echo '</ul>';
            echo '</li>';
        } else {
            // Élément simple
            echo '<li><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($item['nom']) . '</a></li>';
        }
    }
}
?>
<!-- Bouton menu mobile (toujours visible) -->
<label for="menu-toggle" class="menu-icon"><i class="bx bx-menu"></i></label>
<input type="checkbox" id="menu-toggle">

<!-- Navigation latérale gauche -->
<nav class="sidebar">
    <div class="logo">
        <a href="<?php echo htmlspecialchars($basePath); ?>accueil">
            <img src="<?php echo htmlspecialchars($basePath); ?>gallery/oscar.jpeg" alt="Ma photo" class="profile-photo">
            <span class="logo-text">Mon Portfolio</span>
        </a>
    </div>
    
    <ul class="navbar">
        <!-- Menu par défaut (toujours affiché) -->
        <li><a href="<?php echo htmlspecialchars($basePath); ?>accueil"><i class="ri-home-line"></i> Accueil</a></li>
        <li><a href="<?php echo htmlspecialchars($basePath); ?>bts"><i class="ri-book-line"></i> Présentation BTS SIO</a></li>
        <li><a href="<?php echo htmlspecialchars($basePath); ?>mon-profil"><i class="ri-user-line"></i> Mon profil</a></li>
        
        <li class="has-submenu">
            <input type="checkbox" id="submenu-competences" class="submenu-toggle">
            <label for="submenu-competences"><i class="ri-tools-line"></i> Mes compétences <i class="ri-arrow-down-s-line arrow"></i></label>
            <ul class="submenu">
                <li><a href="<?php echo htmlspecialchars($basePath); ?>competences-techniques">Compétences techniques</a></li>
                <li><a href="<?php echo htmlspecialchars($basePath); ?>soft-skills">Soft skills</a></li>
            </ul>
        </li>
        
        <li class="has-submenu">
            <input type="checkbox" id="submenu-projets" class="submenu-toggle">
            <label for="submenu-projets"><i class="ri-folder-line"></i> Mes projets <i class="ri-arrow-down-s-line arrow"></i></label>
            <ul class="submenu">
                <li><a href="<?php echo htmlspecialchars($basePath); ?>epreuve-e5"><i class="ri-file-list-3-line"></i> Épreuve E5</a></li>
                <li><a href="<?php echo htmlspecialchars($basePath); ?>epreuve-e6"><i class="ri-code-box-line"></i> Épreuve E6</a></li>
            </ul>
        </li>
        
        <li><a href="<?php echo htmlspecialchars($basePath); ?>passion"><i class="ri-image-line"></i> Ma passion</a></li>
        <li><a href="<?php echo htmlspecialchars($basePath); ?>contact"><i class="ri-mail-line"></i> Contact</a></li>
        
        <!-- Menu dynamique depuis la base de données (ajouté après le menu par défaut) -->
        <?php if (!empty($menuItems)): ?>
            <?php renderMenuItems($menuItems, $basePath); ?>
        <?php endif; ?>
    </ul>

    <div class="nav-footer">
        <a href="<?php echo htmlspecialchars($basePath); ?>admin/login" class="admin-link"><i class="ri-lock-line"></i> Administration</a>
    </div>
</nav>

