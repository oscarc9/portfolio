<?php
/**
 * Modèle User - Gestion des utilisateurs
 */
class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Trouve un utilisateur par login
     * @param string $login Login de l'utilisateur
     * @return array|null Données de l'utilisateur ou null
     */
    public function findByLogin($login) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE login = ? LIMIT 1");
            $stmt->execute([$login]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur User::findByLogin: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Trouve un utilisateur par ID
     * @param int $id ID de l'utilisateur
     * @return array|null Données de l'utilisateur ou null
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("SELECT id, login, role, created_at FROM users WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur User::findById: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Crée un nouvel utilisateur
     * @param string $login Login
     * @param string $password Mot de passe (en clair)
     * @param string $role Rôle (défaut: admin)
     * @return bool True si succès
     */
    public function create($login, $password, $role = 'admin') {
        require_once __DIR__ . '/../utils/Security.php';
        
        try {
            $hashedPassword = Security::hashPassword($password);
            $stmt = $this->db->prepare("INSERT INTO users (login, mot_de_passe, role) VALUES (?, ?, ?)");
            return $stmt->execute([$login, $hashedPassword, $role]);
        } catch (PDOException $e) {
            error_log("Erreur User::create: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Met à jour le mot de passe d'un utilisateur
     * @param int $id ID de l'utilisateur
     * @param string $newPassword Nouveau mot de passe (en clair)
     * @return bool True si succès
     */
    public function updatePassword($id, $newPassword) {
        require_once __DIR__ . '/../utils/Security.php';
        
        try {
            $hashedPassword = Security::hashPassword($newPassword);
            $stmt = $this->db->prepare("UPDATE users SET mot_de_passe = ? WHERE id = ?");
            return $stmt->execute([$hashedPassword, $id]);
        } catch (PDOException $e) {
            error_log("Erreur User::updatePassword: " . $e->getMessage());
            return false;
        }
    }
}

