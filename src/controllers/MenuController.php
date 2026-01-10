<?php
/**
 * Contrôleur Menu - Gestion du menu
 */
require_once __DIR__ . '/../utils/Security.php';
require_once __DIR__ . '/../models/Menu.php';
require_once __DIR__ . '/../models/Page.php';

// S'assurer que getBasePath() est disponible
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

class MenuController {
    private $db;
    private $menuModel;
    private $pageModel;
    
    public function __construct($db) {
        $this->db = $db;
        if ($db !== null) {
            $this->menuModel = new Menu($db);
            $this->pageModel = new Page($db);
        } else {
            throw new Exception("MenuController nécessite une connexion à la base de données");
        }
    }
    
    /**
     * Liste tous les éléments de menu (admin)
     */
    public function list() {
        Security::requireAdmin();
        
        $menuItems = [];
        $allPages = [];
        if ($this->menuModel !== null && $this->pageModel !== null) {
            try {
                $menuItems = $this->menuModel->getHierarchical();
                $allPages = $this->pageModel->findAll();
            } catch (Exception $e) {
                error_log("Erreur MenuController::list: " . $e->getMessage());
                $menuItems = [];
                $allPages = [];
            }
        }
        
        include __DIR__ . '/../views/admin/menu/list.php';
    }
    
    /**
     * Affiche le formulaire de création (admin)
     */
    public function create() {
        Security::requireAdmin();
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $lien = trim($_POST['lien'] ?? '');
            $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            $pageId = !empty($_POST['page_id']) ? (int)$_POST['page_id'] : null;
            
            if (empty($nom)) {
                $error = 'Le nom est obligatoire';
            } else {
                $data = [
                    'nom' => Security::sanitize($nom),
                    'lien' => !empty($lien) ? Security::sanitize($lien) : null,
                    'parent_id' => $parentId,
                    'page_id' => $pageId
                ];
                
                if ($this->menuModel->create($data)) {
                    $success = 'Élément de menu créé avec succès';
                    header('Location: ' . getBasePath() . 'admin/menu?success=' . urlencode($success));
                    exit;
                } else {
                    $error = 'Erreur lors de la création de l\'élément de menu';
                }
            }
        }
        
        $allPages = [];
        $allMenuItems = [];
        if ($this->pageModel !== null && $this->menuModel !== null) {
            try {
                $allPages = $this->pageModel->findAll();
                $allMenuItems = $this->menuModel->findAll();
            } catch (Exception $e) {
                error_log("Erreur MenuController::create: " . $e->getMessage());
                $allPages = [];
                $allMenuItems = [];
            }
        }
        
        include __DIR__ . '/../views/admin/menu/create.php';
    }
    
    /**
     * Affiche le formulaire d'édition (admin)
     */
    public function edit() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        $menuItem = $this->menuModel->findById($id);
        
        if (!$menuItem) {
            header('Location: ' . getBasePath() . 'admin/menu');
            exit;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $lien = trim($_POST['lien'] ?? '');
            $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            $pageId = !empty($_POST['page_id']) ? (int)$_POST['page_id'] : null;
            
            if (empty($nom)) {
                $error = 'Le nom est obligatoire';
            } else {
                $data = [
                    'nom' => Security::sanitize($nom),
                    'lien' => !empty($lien) ? Security::sanitize($lien) : null,
                    'parent_id' => $parentId,
                    'page_id' => $pageId
                ];
                
                if ($this->menuModel->update($id, $data)) {
                    $success = 'Élément de menu modifié avec succès';
                    header('Location: ' . getBasePath() . 'admin/menu?success=' . urlencode($success));
                    exit;
                } else {
                    $error = 'Erreur lors de la modification de l\'élément de menu';
                }
            }
        }
        
        $allPages = $this->pageModel->findAll();
        $allMenuItems = $this->menuModel->findAll();
        
        include __DIR__ . '/../views/admin/menu/edit.php';
    }
    
    /**
     * Supprime un élément de menu (admin)
     */
    public function delete() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        
        if ($this->menuModel->delete($id)) {
            $success = 'Élément de menu supprimé avec succès';
        } else {
            $error = 'Erreur lors de la suppression de l\'élément de menu';
        }
        
        header('Location: ' . getBasePath() . 'admin/menu?' . (isset($success) ? 'success=' . urlencode($success) : 'error=' . urlencode($error)));
        exit;
    }
}

