<?php
// Définir le chemin racine du projet
$rootPath = dirname(__DIR__);

// Charger les configurations
require_once $rootPath . '/config/paths.php';
require_once $rootPath . '/config/db.php';
require_once $rootPath . '/src/utils/Security.php';
require_once $rootPath . '/src/controllers/ContactController.php';

// Démarrer la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Essayer de se connecter à la BDD, sinon utiliser null
try {
    $db = getDatabaseConnection();
} catch (Exception $e) {
    // Si pas de BDD, continuer sans (le formulaire fonctionnera quand même)
    $db = null;
    error_log("Erreur connexion BDD pour contact: " . $e->getMessage());
}

// Créer le contrôleur et afficher la page
$controller = new ContactController($db);
$controller->index();

