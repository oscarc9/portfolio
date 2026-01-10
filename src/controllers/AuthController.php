<?php
/**
 * Contrôleur d'authentification
 */
require_once __DIR__ . '/../utils/Security.php';

// S'assurer que getBasePath() est disponible
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

class AuthController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Affiche le formulaire de connexion
     */
    public function login() {
        // Si déjà connecté, rediriger vers le dashboard
        if (Security::isLoggedIn()) {
            header('Location: ' . getBasePath() . 'admin/dashboard');
            exit;
        }
        
        $error = '';
        
        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if (empty($login) || empty($password)) {
                $error = 'Veuillez remplir tous les champs';
            } else {
                try {
                    $stmt = $this->db->prepare("SELECT id, login, mot_de_passe, role FROM users WHERE login = ? LIMIT 1");
                    $stmt->execute([$login]);
                    $user = $stmt->fetch();
                    
                    if ($user && Security::verifyPassword($password, $user['mot_de_passe'])) {
                        // Connexion réussie
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_login'] = $user['login'];
                        $_SESSION['user_role'] = $user['role'];
                        $_SESSION['logged_in'] = true;
                        
                        header('Location: ' . getBasePath() . 'admin/dashboard');
                        exit;
                    } else {
                        $error = 'Identifiants incorrects';
                    }
                } catch (PDOException $e) {
                    $error = 'Erreur de connexion à la base de données';
                    error_log("Erreur AuthController::login: " . $e->getMessage());
                }
            }
        }
        
        // Afficher le formulaire
        include __DIR__ . '/../views/admin/login.php';
    }
    
    /**
     * Déconnexion de l'utilisateur
     */
    public function logout() {
        // Détruire toutes les variables de session
        $_SESSION = [];
        
        // Détruire le cookie de session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Détruire la session
        session_destroy();
        
        // Rediriger vers la page de connexion
        header('Location: ' . getBasePath() . 'admin/login');
        exit;
    }
    
    /**
     * Affiche le tableau de bord admin
     */
    public function dashboard() {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        Security::requireAdmin();
        
        // Initialiser les variables par défaut
        $pagesCount = 0;
        $mediaCount = 0;
        $menuCount = 0;
        
        // Statistiques
        if ($this->db !== null) {
            try {
                $result = $this->db->query("SELECT COUNT(*) FROM pages")->fetchColumn();
                $pagesCount = ($result !== false) ? (int)$result : 0;
            } catch (PDOException $e) {
                error_log("Erreur AuthController::dashboard (pages): " . $e->getMessage());
                $pagesCount = 0;
            }
            
            try {
                $result = $this->db->query("SELECT COUNT(*) FROM media")->fetchColumn();
                $mediaCount = ($result !== false) ? (int)$result : 0;
            } catch (PDOException $e) {
                error_log("Erreur AuthController::dashboard (media): " . $e->getMessage());
                $mediaCount = 0;
            }
            
            try {
                $result = $this->db->query("SELECT COUNT(*) FROM menu")->fetchColumn();
                $menuCount = ($result !== false) ? (int)$result : 0;
            } catch (PDOException $e) {
                error_log("Erreur AuthController::dashboard (menu): " . $e->getMessage());
                $menuCount = 0;
            }
        }
        
        include __DIR__ . '/../views/admin/dashboard.php';
    }
}

