<?php
/**
 * Point d'entrée principal du Portfolio CMS
 * Gère le routage de toutes les requêtes
 */

// TEMPORAIRE - Mode debug pour Cloudways (à retirer en production)
// Décommenter les lignes suivantes pour voir les erreurs :
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// Démarrer la session
session_start();

// Charger les configurations
require_once __DIR__ . '/config/paths.php';
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/src/utils/Router.php';

// Obtenir l'URL demandée
// Si le paramètre "url" n'est pas passé (cas où la réécriture ne forwarde pas),
// on récupère l'URI et on enlève le slash initial.
$url = $_GET['url'] ?? '';
if ($url === '' || $url === null) {
    $uri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $url = ltrim($uri, '/');
}

// Créer une instance du routeur
try {
    $db = getDatabaseConnection();
    $router = new Router($db);
} catch (PDOException $e) {
    // Si erreur de connexion BDD, router sans BDD (mode dégradé)
    $router = new Router(null);
    error_log("Erreur connexion BDD: " . $e->getMessage());
}

// Résoudre la route
$route = $router->resolve($url);

// Traiter la route
if ($route === null) {
    // Route non trouvée - 404
    http_response_code(404);
    include __DIR__ . '/src/views/errors/404.php';
    exit;
}

// Gérer les différents types de routes
if ($route['type'] === 'static_file') {
    // Page statique existante
    $file = __DIR__ . '/' . $route['file'];
    if (file_exists($file)) {
        include $file;
    } else {
        http_response_code(404);
        include __DIR__ . '/src/views/errors/404.php';
    }
} elseif ($route['type'] === 'dynamic' && isset($route['page'])) {
    // Page dynamique depuis la BDD
    require_once __DIR__ . '/src/controllers/PageController.php';
    $controller = new PageController($db);
    $controller->show($route['page']);
} elseif (isset($route['controller']) && $route['controller'] !== null) {
    // Route avec contrôleur
    $controllerFile = __DIR__ . '/src/controllers/' . $route['controller'] . '.php';
    if (file_exists($controllerFile)) {
        try {
            require_once $controllerFile;
            $controllerName = $route['controller'];
            
            // Vérifier si le contrôleur nécessite la BDD
            try {
                if ($db === null) {
                    $db = getDatabaseConnection();
                }
                $controller = new $controllerName($db);
            } catch (PDOException $e) {
                // Si pas de BDD, essayer sans
                try {
                    $controller = new $controllerName(null);
                } catch (Exception $e2) {
                    error_log("Erreur création contrôleur (sans BDD): " . $e2->getMessage());
                    http_response_code(500);
                    include __DIR__ . '/src/views/errors/404.php';
                    exit;
                }
            }
            
            $method = $route['method'] ?? 'index';
            if (method_exists($controller, $method)) {
                try {
                    $controller->$method();
                } catch (Exception $e) {
                    error_log("Erreur exécution méthode $method: " . $e->getMessage());
                    error_log("Stack trace: " . $e->getTraceAsString());
                    http_response_code(500);
                    echo "Erreur serveur: " . htmlspecialchars($e->getMessage());
                    exit;
                }
            } else {
                error_log("Méthode $method n'existe pas dans $controllerName");
                http_response_code(404);
                include __DIR__ . '/src/views/errors/404.php';
            }
        } catch (Exception $e) {
            error_log("Erreur générale contrôleur: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            echo "Erreur serveur: " . htmlspecialchars($e->getMessage());
            exit;
        }
    } else {
        error_log("Fichier contrôleur non trouvé: $controllerFile");
        http_response_code(404);
        include __DIR__ . '/src/views/errors/404.php';
    }
} else {
    // Fallback vers page statique
    http_response_code(404);
    include __DIR__ . '/src/views/errors/404.php';
}
