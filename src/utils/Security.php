<?php
/**
 * Classe Security - Fonctions de sécurité
 */
class Security {
    
    /**
     * Hash un mot de passe avec bcrypt
     * @param string $password Mot de passe en clair
     * @return string Hash du mot de passe
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    
    /**
     * Vérifie un mot de passe contre un hash
     * @param string $password Mot de passe en clair
     * @param string $hash Hash stocké
     * @return bool True si le mot de passe correspond
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Nettoie une chaîne pour éviter les injections XSS
     * @param string|null $data Données à nettoyer
     * @return string Données nettoyées
     */
    public static function sanitize($data) {
        if ($data === null || $data === '') {
            return '';
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Nettoie un tableau de données
     * @param array $data Tableau à nettoyer
     * @return array Tableau nettoyé
     */
    public static function sanitizeArray($data) {
        $cleaned = [];
        foreach ($data as $key => $value) {
            $cleaned[$key] = is_array($value) ? self::sanitizeArray($value) : self::sanitize($value);
        }
        return $cleaned;
    }
    
    /**
     * Génère un token CSRF
     * @return string Token CSRF
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Vérifie un token CSRF
     * @param string $token Token à vérifier
     * @return bool True si le token est valide
     */
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Vérifie si l'utilisateur est connecté
     * @return bool True si connecté
     */
    public static function isLoggedIn() {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Vérifie si l'utilisateur est administrateur
     * @return bool True si admin
     */
    public static function isAdmin() {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return self::isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
    
    /**
     * Requiert une authentification
     * Redirige vers login si non connecté
     */
    public static function requireAuth() {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!self::isLoggedIn()) {
            if (!function_exists('getBasePath')) {
                require_once __DIR__ . '/../../config/paths.php';
            }
            header('Location: ' . getBasePath() . 'admin/login');
            exit;
        }
    }
    
    /**
     * Requiert le rôle administrateur
     * Redirige vers login si non admin
     */
    public static function requireAdmin() {
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!self::isAdmin()) {
            if (!function_exists('getBasePath')) {
                require_once __DIR__ . '/../../config/paths.php';
            }
            header('Location: ' . getBasePath() . 'admin/login');
            exit;
        }
    }
}

