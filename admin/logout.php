<?php
/**
 * Page de déconnexion
 */
// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config/paths.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/utils/Security.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';

// Essayer de se connecter à la BDD (pas critique pour logout)
try {
    $db = getDatabaseConnection();
} catch (PDOException $e) {
    $db = null;
}

$controller = new AuthController($db);
$controller->logout();

