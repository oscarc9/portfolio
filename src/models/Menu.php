<?php
/**
 * Modèle Menu - Gestion du menu
 */
class Menu {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Trouve un élément de menu par ID
     * @param int $id ID du menu
     * @return array|null Données du menu ou null
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM menu WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur Menu::findById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Récupère tous les éléments de menu
     * @return array Liste des éléments de menu
     */
    public function findAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM menu ORDER BY ordre ASC, nom ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur Menu::findAll: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupère le menu avec hiérarchie
     * @return array Menu organisé par parent
     */
    public function getHierarchical() {
        $items = $this->findAll();
        $tree = [];
        
        // Créer un index par ID
        $indexed = [];
        foreach ($items as $item) {
            $indexed[$item['id']] = $item;
            $indexed[$item['id']]['children'] = [];
        }
        
        // Construire l'arbre
        foreach ($indexed as $item) {
            if ($item['parent_id'] === null) {
                $tree[] = &$indexed[$item['id']];
            } else {
                if (isset($indexed[$item['parent_id']])) {
                    $indexed[$item['parent_id']]['children'][] = &$indexed[$item['id']];
                }
            }
        }
        
        return $tree;
    }
    
    /**
     * Crée un nouvel élément de menu
     * @param array $data Données du menu
     * @return int|false ID du menu créé ou false
     */
    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO menu (nom, lien, parent_id, ordre, page_id) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['nom'],
                $data['lien'] ?? null,
                $data['parent_id'] ?? null,
                $data['ordre'] ?? 0,
                $data['page_id'] ?? null
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur Menu::create: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Met à jour un élément de menu
     * @param int $id ID du menu
     * @param array $data Données à mettre à jour
     * @return bool True si succès
     */
    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if (in_array($key, ['nom', 'lien', 'parent_id', 'ordre', 'page_id'])) {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $values[] = $id;
            $sql = "UPDATE menu SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Erreur Menu::update: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Supprime un élément de menu
     * @param int $id ID du menu
     * @return bool True si succès
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM menu WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur Menu::delete: " . $e->getMessage());
            return false;
        }
    }
}

