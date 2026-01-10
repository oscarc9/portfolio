<?php
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/utils/Security.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

// Essayer de se connecter à la BDD
try {
    $db = getDatabaseConnection();
} catch (PDOException $e) {
    // Si erreur de connexion, rediriger vers login avec message d'erreur
    $_SESSION['error'] = 'Erreur de connexion à la base de données. Vérifiez la configuration.';
    header('Location: ' . getBasePath() . 'admin/login');
    exit;
}

$controller = new AuthController($db);
$controller->dashboard();

