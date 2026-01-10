<?php
/**
 * Configuration de la base de données
 * 
 * IMPORTANT : Configurez ces valeurs selon votre serveur Cloudways
 * Vous trouverez ces informations dans le panneau Cloudways :
 * - Applications > Votre app > Access Details > Database Access
 */
$DB_HOST = 'localhost'; // Généralement 'localhost' sur Cloudways
$DB_NAME = 'eygjbafwra';
$DB_USER = 'eygjbafwra';
$DB_PASS = '9Ngh3wqjs5';
$DB_CHARSET = 'utf8mb4';

/**
 * Obtient une connexion PDO à la base de données
 * @return PDO Instance de connexion PDO
 * @throws PDOException En cas d'erreur de connexion
 */
function getDatabaseConnection() {
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET;
    
    static $pdo = null;
    
    if ($pdo === null) {
        $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }
    
    return $pdo;
}
?>