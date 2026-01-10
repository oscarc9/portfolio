<?php
/**
 * Modèle Media - Gestion des médias (images et PDF)
 */
class Media {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Trouve un média par ID
     * @param int $id ID du média
     * @return array|null Données du média ou null
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM media WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur Media::findById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Récupère tous les médias
     * @param string|null $type Type de média (image/pdf) ou null pour tous
     * @return array Liste des médias
     */
    public function findAll($type = null) {
        try {
            if ($type) {
                $stmt = $this->db->prepare("SELECT * FROM media WHERE type = ? ORDER BY created_at DESC");
                $stmt->execute([$type]);
            } else {
                $stmt = $this->db->query("SELECT * FROM media ORDER BY created_at DESC");
            }
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur Media::findAll: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupère les médias d'une page
     * @param int $pageId ID de la page
     * @return array Liste des médias
     */
    public function findByPageId($pageId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM media WHERE page_id = ? ORDER BY created_at DESC");
            $stmt->execute([$pageId]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur Media::findByPageId: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Crée un nouveau média
     * @param array $data Données du média
     * @return int|false ID du média créé ou false
     */
    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO media (type, fichier, page_id) 
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $data['type'],
                $data['fichier'],
                $data['page_id'] ?? null
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur Media::create: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Supprime un média
     * @param int $id ID du média
     * @return bool True si succès
     */
    public function delete($id) {
        try {
            // Récupérer le fichier avant suppression
            $media = $this->findById($id);
            
            $stmt = $this->db->prepare("DELETE FROM media WHERE id = ?");
            $result = $stmt->execute([$id]);
            
            // Supprimer le fichier physique si existe
            if ($result && $media && file_exists(__DIR__ . '/../../public/uploads/' . $media['fichier'])) {
                unlink(__DIR__ . '/../../public/uploads/' . $media['fichier']);
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur Media::delete: " . $e->getMessage());
            return false;
        }
    }
}

