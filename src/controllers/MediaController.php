<?php
/**
 * Contrôleur Media - Gestion des médias
 */
require_once __DIR__ . '/../utils/Security.php';
require_once __DIR__ . '/../models/Media.php';

// S'assurer que getBasePath() est disponible
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

class MediaController {
    private $db;
    private $mediaModel;
    private $uploadDir;
    
    // Types MIME autorisés
    private $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    private $allowedPdfTypes = ['application/pdf'];
    
    // Extensions autorisées
    private $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private $allowedPdfExtensions = ['pdf'];
    
    // Taille max (5MB)
    private $maxFileSize = 5 * 1024 * 1024;
    
    public function __construct($db) {
        $this->db = $db;
        if ($db !== null) {
            $this->mediaModel = new Media($db);
        } else {
            throw new Exception("MediaController nécessite une connexion à la base de données");
        }
        $this->uploadDir = __DIR__ . '/../../public/uploads/';
        
        // Créer le dossier uploads s'il n'existe pas
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }
    
    /**
     * Liste tous les médias (admin)
     */
    public function list() {
        Security::requireAdmin();
        
        $type = $_GET['type'] ?? null;
        $media = [];
        if ($this->mediaModel !== null) {
            try {
                $media = $this->mediaModel->findAll($type);
            } catch (Exception $e) {
                error_log("Erreur MediaController::list: " . $e->getMessage());
                $media = [];
            }
        }
        
        include __DIR__ . '/../views/admin/media/list.php';
    }
    
    /**
     * Affiche le formulaire d'upload (admin)
     */
    public function upload() {
        Security::requireAdmin();
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $result = $this->handleUpload($_FILES['file'], $_POST['type'] ?? 'image', $_POST['page_id'] ?? null);
            
            if ($result['success']) {
                $success = 'Fichier uploadé avec succès';
            } else {
                $error = $result['error'];
            }
        }
        
        // Récupérer les pages pour le select
        $pages = [];
        try {
            require_once __DIR__ . '/../models/Page.php';
            $pageModel = new Page($this->db);
            $pages = $pageModel->findAll();
        } catch (Exception $e) {
            error_log("Erreur MediaController::upload (pages): " . $e->getMessage());
            $pages = [];
        }
        
        include __DIR__ . '/../views/admin/media/upload.php';
    }
    
    /**
     * Gère l'upload d'un fichier
     * @param array $file Fichier uploadé
     * @param string $type Type de média (image/pdf)
     * @param int|null $pageId ID de la page associée
     * @return array Résultat de l'upload
     */
    private function handleUpload($file, $type, $pageId = null) {
        // Vérifier les erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Erreur lors de l\'upload du fichier'];
        }
        
        // Vérifier la taille
        if ($file['size'] > $this->maxFileSize) {
            return ['success' => false, 'error' => 'Le fichier est trop volumineux (max 5MB)'];
        }
        
        // Vérifier le type MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if ($type === 'image') {
            if (!in_array($mimeType, $this->allowedImageTypes)) {
                return ['success' => false, 'error' => 'Type de fichier non autorisé pour les images'];
            }
        } elseif ($type === 'pdf') {
            if (!in_array($mimeType, $this->allowedPdfTypes)) {
                return ['success' => false, 'error' => 'Type de fichier non autorisé pour les PDF'];
            }
        } else {
            return ['success' => false, 'error' => 'Type de média invalide'];
        }
        
        // Vérifier l'extension
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if ($type === 'image' && !in_array($extension, $this->allowedImageExtensions)) {
            return ['success' => false, 'error' => 'Extension non autorisée pour les images'];
        }
        if ($type === 'pdf' && !in_array($extension, $this->allowedPdfExtensions)) {
            return ['success' => false, 'error' => 'Extension non autorisée pour les PDF'];
        }
        
        // Générer un nom de fichier unique
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = $this->uploadDir . $filename;
        
        // Déplacer le fichier
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => false, 'error' => 'Erreur lors du déplacement du fichier'];
        }
        
        // Enregistrer en base de données
        $data = [
            'type' => $type,
            'fichier' => $filename,
            'page_id' => $pageId ? (int)$pageId : null
        ];
        
        $mediaId = $this->mediaModel->create($data);
        
        if ($mediaId) {
            return ['success' => true, 'media_id' => $mediaId, 'filename' => $filename];
        } else {
            // Supprimer le fichier si erreur BDD
            unlink($destination);
            return ['success' => false, 'error' => 'Erreur lors de l\'enregistrement en base de données'];
        }
    }
    
    /**
     * Supprime un média (admin)
     */
    public function delete() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        
        if ($this->mediaModel->delete($id)) {
            $success = 'Média supprimé avec succès';
        } else {
            $error = 'Erreur lors de la suppression du média';
        }
        
        header('Location: ' . getBasePath() . 'admin/media?' . (isset($success) ? 'success=' . urlencode($success) : 'error=' . urlencode($error)));
        exit;
    }
}

