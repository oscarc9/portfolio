<?php
/**
 * Modèle Page - Gestion des pages
 */
class Page {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Trouve une page par slug
     * @param string $slug Slug de la page
     * @return array|null Données de la page ou null
     */
    public function findBySlug($slug) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pages WHERE slug = ? LIMIT 1");
            $stmt->execute([$slug]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur Page::findBySlug: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Trouve une page par ID
     * @param int $id ID de la page
     * @return array|null Données de la page ou null
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur Page::findById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Récupère toutes les pages
     * @return array Liste des pages
     */
    public function findAll() {
        try {
            $stmt = $this->db->query("SELECT * FROM pages ORDER BY ordre ASC, titre ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur Page::findAll: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Récupère les pages avec hiérarchie
     * @return array Liste des pages organisées par parent
     */
    public function findAllHierarchical() {
        $pages = $this->findAll();
        $tree = [];
        
        foreach ($pages as $page) {
            if ($page['parent_id'] === null) {
                $tree[$page['id']] = $page;
                $tree[$page['id']]['children'] = [];
            }
        }
        
        foreach ($pages as $page) {
            if ($page['parent_id'] !== null && isset($tree[$page['parent_id']])) {
                $tree[$page['parent_id']]['children'][] = $page;
            }
        }
        
        return $tree;
    }
    
    /**
     * Crée une nouvelle page
     * @param array $data Données de la page
     * @return int|false ID de la page créée ou false
     */
    public function create($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO pages (titre, slug, contenu, parent_id, ordre) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['titre'],
                $data['slug'],
                $data['contenu'] ?? '',
                $data['parent_id'] ?? null,
                $data['ordre'] ?? 0
            ]);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erreur Page::create: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Met à jour une page
     * @param int $id ID de la page
     * @param array $data Données à mettre à jour
     * @return bool True si succès
     */
    public function update($id, $data) {
        try {
            $fields = [];
            $values = [];
            
            foreach ($data as $key => $value) {
                if (in_array($key, ['titre', 'slug', 'contenu', 'parent_id', 'ordre'])) {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $values[] = $id;
            $sql = "UPDATE pages SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Erreur Page::update: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Supprime une page
     * @param int $id ID de la page
     * @return bool True si succès
     */
    public function delete($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM pages WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur Page::delete: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Génère un slug à partir d'un titre
     * @param string $titre Titre de la page
     * @return string Slug généré
     */
    public function generateSlug($titre) {
        $slug = strtolower(trim($titre));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Vérifier l'unicité
        $originalSlug = $slug;
        $counter = 1;
        while ($this->findBySlug($slug)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}

