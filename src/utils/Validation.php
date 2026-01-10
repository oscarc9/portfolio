<?php
/**
 * Classe Validation - Fonctions de validation de formulaires
 */
class Validation {
    
    /**
     * Valide une adresse email
     * @param string $email Email à valider
     * @return bool True si valide
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Valide une URL
     * @param string $url URL à valider
     * @return bool True si valide
     */
    public static function validateUrl($url) {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
    
    /**
     * Valide un nombre entier
     * @param mixed $value Valeur à valider
     * @param int|null $min Valeur minimale (optionnel)
     * @param int|null $max Valeur maximale (optionnel)
     * @return bool True si valide
     */
    public static function validateInteger($value, $min = null, $max = null) {
        if (!is_numeric($value)) {
            return false;
        }
        
        $int = (int)$value;
        
        if ($min !== null && $int < $min) {
            return false;
        }
        
        if ($max !== null && $int > $max) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Valide la longueur d'une chaîne
     * @param string $value Chaîne à valider
     * @param int $min Longueur minimale
     * @param int|null $max Longueur maximale (optionnel)
     * @return bool True si valide
     */
    public static function validateLength($value, $min, $max = null) {
        $length = mb_strlen($value);
        
        if ($length < $min) {
            return false;
        }
        
        if ($max !== null && $length > $max) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Valide un fichier uploadé
     * @param array $file Fichier uploadé ($_FILES['name'])
     * @param array $allowedTypes Types MIME autorisés
     * @param array $allowedExtensions Extensions autorisées
     * @param int $maxSize Taille maximale en octets
     * @return array ['valid' => bool, 'error' => string]
     */
    public static function validateFile($file, $allowedTypes = [], $allowedExtensions = [], $maxSize = 5242880) {
        // Vérifier les erreurs d'upload
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['valid' => false, 'error' => 'Erreur lors de l\'upload du fichier'];
        }
        
        // Vérifier la taille
        if ($file['size'] > $maxSize) {
            return ['valid' => false, 'error' => 'Le fichier est trop volumineux (max ' . ($maxSize / 1024 / 1024) . 'MB)'];
        }
        
        // Vérifier le type MIME
        if (!empty($allowedTypes)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                return ['valid' => false, 'error' => 'Type de fichier non autorisé'];
            }
        }
        
        // Vérifier l'extension
        if (!empty($allowedExtensions)) {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowedExtensions)) {
                return ['valid' => false, 'error' => 'Extension de fichier non autorisée'];
            }
        }
        
        return ['valid' => true, 'error' => ''];
    }
    
    /**
     * Nettoie et valide une chaîne
     * @param string $value Valeur à nettoyer
     * @param bool $trim Supprimer les espaces (défaut: true)
     * @return string Valeur nettoyée
     */
    public static function sanitizeString($value, $trim = true) {
        if ($trim) {
            $value = trim($value);
        }
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Valide un slug (URL-friendly)
     * @param string $slug Slug à valider
     * @return bool True si valide
     */
    public static function validateSlug($slug) {
        return preg_match('/^[a-z0-9-]+$/', $slug) === 1;
    }
    
    /**
     * Valide un mot de passe (force minimale)
     * @param string $password Mot de passe à valider
     * @param int $minLength Longueur minimale (défaut: 8)
     * @return array ['valid' => bool, 'error' => string]
     */
    public static function validatePassword($password, $minLength = 8) {
        if (mb_strlen($password) < $minLength) {
            return ['valid' => false, 'error' => 'Le mot de passe doit contenir au moins ' . $minLength . ' caractères'];
        }
        
        return ['valid' => true, 'error' => ''];
    }
}

