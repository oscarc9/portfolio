<?php
/**
 * Contrôleur Page - Gestion des pages
 */
require_once __DIR__ . '/../utils/Security.php';
require_once __DIR__ . '/../models/Page.php';

// S'assurer que getBasePath() est disponible
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

class PageController {
    private $db;
    private $pageModel;
    
    public function __construct($db) {
        $this->db = $db;
        if ($db !== null) {
            $this->pageModel = new Page($db);
        } else {
            throw new Exception("PageController nécessite une connexion à la base de données");
        }
    }
    
    /**
     * Affiche une page (front-office)
     * @param array|null $pageData Données de la page (si déjà chargées)
     */
    public function show($pageData = null) {
        if ($pageData === null) {
            // Récupérer depuis l'URL
            $slug = $_GET['slug'] ?? '';
            $pageData = $this->pageModel->findBySlug($slug);
        }
        
        if (!$pageData) {
            http_response_code(404);
            include __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        // Afficher la page
        $pageTitle = $pageData['titre'] ?? 'Page';
        $pageCSS = 'bts.css';
        
        // S'assurer que les dépendances sont chargées
        if (!function_exists('getBasePath')) {
            require_once __DIR__ . '/../../config/paths.php';
        }
        if (!isset($basePath)) {
            $basePath = getBasePath();
        }
        
        // Passer les variables nécessaires à la vue
        $db = $this->db;
        // $pageData est déjà défini et sera accessible dans la vue
        
        include __DIR__ . '/../views/includes/header.php';
        include __DIR__ . '/../views/includes/sidebar.php';
        include __DIR__ . '/../views/front/page.php';
        include __DIR__ . '/../views/includes/footer.php';
    }
    
    /**
     * Liste toutes les pages (admin)
     */
    public function list() {
        Security::requireAdmin();
        
        $pages = [];
        if ($this->pageModel !== null) {
            try {
                $pages = $this->pageModel->findAll();
            } catch (Exception $e) {
                error_log("Erreur PageController::list: " . $e->getMessage());
                $pages = [];
            }
        }
        include __DIR__ . '/../views/admin/pages/list.php';
    }
    
    /**
     * Affiche le formulaire de création (admin)
     */
    public function create() {
        Security::requireAdmin();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre'] ?? '');
            $contenu = $_POST['contenu'] ?? '';
            $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            
            if (empty($titre)) {
                $error = 'Le titre est obligatoire';
            } else {
                $slug = $this->pageModel->generateSlug($titre);
                $data = [
                    'titre' => Security::sanitize($titre),
                    'slug' => $slug,
                    'contenu' => $contenu,
                    'parent_id' => $parentId
                ];
                
                if ($this->pageModel->create($data)) {
                    $success = 'Page créée avec succès';
                    header('Location: ' . getBasePath() . 'admin/pages?success=' . urlencode($success));
                    exit;
                } else {
                    $error = 'Erreur lors de la création de la page';
                }
            }
        }
        
        $allPages = [];
        if ($this->pageModel !== null) {
            try {
                $allPages = $this->pageModel->findAll();
            } catch (Exception $e) {
                error_log("Erreur PageController::create (pages): " . $e->getMessage());
                $allPages = [];
            }
        }
        include __DIR__ . '/../views/admin/pages/create.php';
    }
    
    /**
     * Affiche le formulaire d'édition (admin)
     */
    public function edit() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        $page = $this->pageModel->findById($id);
        
        if (!$page) {
            header('Location: ' . getBasePath() . 'admin/pages');
            exit;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre'] ?? '');
            $contenu = $_POST['contenu'] ?? '';
            $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            
            if (empty($titre)) {
                $error = 'Le titre est obligatoire';
            } else {
                $data = [
                    'titre' => Security::sanitize($titre),
                    'contenu' => $contenu,
                    'parent_id' => $parentId
                ];
                
                if ($this->pageModel->update($id, $data)) {
                    $success = 'Page modifiée avec succès';
                    header('Location: ' . getBasePath() . 'admin/pages?success=' . urlencode($success));
                    exit;
                } else {
                    $error = 'Erreur lors de la modification de la page';
                }
            }
        }
        
        $allPages = $this->pageModel->findAll();
        include __DIR__ . '/../views/admin/pages/edit.php';
    }
    
    /**
     * Supprime une page (admin)
     */
    public function delete() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        
        if ($this->pageModel->delete($id)) {
            $success = 'Page supprimée avec succès';
        } else {
            $error = 'Erreur lors de la suppression de la page';
        }
        
        header('Location: ' . getBasePath() . 'admin/pages?' . (isset($success) ? 'success=' . urlencode($success) : 'error=' . urlencode($error)));
        exit;
    }
}

