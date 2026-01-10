<?php
/**
 * Classe Router - Gestion du routage des URLs
 */
class Router {
    private $routes = [];
    private $db = null;
    
    public function __construct($db = null) {
        $this->db = $db;
        // Charger les routes depuis config/routes.php
        $this->loadRoutes();
    }
    
    /**
     * Charge les routes depuis config/routes.php
     */
    private function loadRoutes() {
        $routesFile = __DIR__ . '/../../config/routes.php';
        if (file_exists($routesFile)) {
            $configRoutes = require $routesFile;
            foreach ($configRoutes as $path => $config) {
                if (isset($config['file'])) {
                    // Route vers un fichier statique
                    $this->routes[$path] = [
                        'controller' => null,
                        'method' => null,
                        'type' => 'static_file',
                        'file' => $config['file']
                    ];
                } elseif (isset($config['controller'])) {
                    // Route vers un contrôleur
                    $this->routes[$path] = [
                        'controller' => $config['controller'],
                        'method' => $config['method'] ?? 'index',
                        'type' => 'controller'
                    ];
                }
            }
        }
        
        // Ajouter toutes les pages statiques connues directement dans $this->routes
        // pour qu'elles soient prioritaires sur la BDD
        $staticPages = $this->getStaticPagesMapping();
        foreach ($staticPages as $slug => $file) {
            if (!isset($this->routes[$slug])) {
                $this->routes[$slug] = [
                    'controller' => null,
                    'method' => null,
                    'type' => 'static_file',
                    'file' => $file
                ];
            }
        }
    }
    
    /**
     * Retourne le mapping des pages statiques
     * @return array
     */
    private function getStaticPagesMapping() {
        return [
            'accueil' => 'main/accueil.php',
            'bts' => 'pages/BTS.php',
            'mon-profil' => 'pages/mon_profil/presentation_perso.php',
            'competences-techniques' => 'pages/competences_tech.php',
            'soft-skills' => 'pages/soft_skills.php',
            'epreuve-e5' => 'pages/e5.php',
            'epreuve-e6' => 'pages/e6.php',
            'passion' => 'pages/passion.php',
            'contact' => 'pages/contact.php'
        ];
    }
    
    /**
     * Ajoute une route statique
     * @param string $path Chemin de l'URL
     * @param string $controller Contrôleur à appeler
     * @param string $method Méthode du contrôleur
     */
    public function addRoute($path, $controller, $method = 'index') {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method,
            'type' => 'static'
        ];
    }
    
    /**
     * Résout l'URL et retourne les informations de route
     * @param string $uri URI à résoudre
     * @return array|null Informations de la route ou null si non trouvée
     */
    public function resolve($uri) {
        // Nettoyer l'URI (enlever les paramètres GET et le slash initial)
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        
        // Si URI vide, route vers accueil
        if (empty($uri)) {
            $uri = 'accueil';
        }
        
        // Vérifier les routes statiques d'abord
        if (isset($this->routes[$uri])) {
            return $this->routes[$uri];
        }
        
        // Chercher dans la base de données pour les routes dynamiques
        if ($this->db !== null) {
            try {
                $stmt = $this->db->prepare("SELECT id, titre, slug, contenu FROM pages WHERE slug = ? LIMIT 1");
                $stmt->execute([$uri]);
                $page = $stmt->fetch();
                
                if ($page) {
                    return [
                        'controller' => 'PageController',
                        'method' => 'show',
                        'type' => 'dynamic',
                        'page' => $page
                    ];
                }
            } catch (PDOException $e) {
                // En cas d'erreur BDD, continuer avec les routes statiques
                error_log("Erreur Router BDD: " . $e->getMessage());
            }
        }
        
        // Vérifier les routes admin
        if (strpos($uri, 'admin/') === 0) {
            $adminPath = substr($uri, 6); // Enlever "admin/"
            
            if ($adminPath === '' || $adminPath === 'dashboard') {
                return [
                    'controller' => 'AuthController',
                    'method' => 'dashboard',
                    'type' => 'admin'
                ];
            }
            
            // Routes admin spécifiques
            $adminRoutes = [
                'login' => ['AuthController', 'login'],
                'logout' => ['AuthController', 'logout'],
                'pages' => ['PageController', 'list'],
                'pages/create' => ['PageController', 'create'],
                'pages/edit' => ['PageController', 'edit'],
                'pages/delete' => ['PageController', 'delete'],
                'media' => ['MediaController', 'list'],
                'media/upload' => ['MediaController', 'upload'],
                'media/delete' => ['MediaController', 'delete'],
                'menu' => ['MenuController', 'list'],
                'menu/create' => ['MenuController', 'create'],
                'menu/edit' => ['MenuController', 'edit'],
                'menu/delete' => ['MenuController', 'delete']
            ];
            
            if (isset($adminRoutes[$adminPath])) {
                return [
                    'controller' => $adminRoutes[$adminPath][0],
                    'method' => $adminRoutes[$adminPath][1],
                    'type' => 'admin'
                ];
            }
        }
        
        // Vérifier si c'est une page statique existante
        $staticPath = $this->checkStaticPage($uri);
        if ($staticPath) {
            return [
                'controller' => null,
                'method' => null,
                'type' => 'static_file',
                'file' => $staticPath
            ];
        }
        
        // Route non trouvée
        return null;
    }
    
    /**
     * Vérifie si une page statique existe
     * @param string $uri URI à vérifier
     * @return string|null Chemin du fichier ou null
     */
    private function checkStaticPage($uri) {
        // Utiliser le mapping centralisé
        $staticPages = $this->getStaticPagesMapping();
        
        if (isset($staticPages[$uri])) {
            return $staticPages[$uri];
        }
        
        return null;
    }
    
    /**
     * Génère une URL propre à partir d'un slug
     * @param string $slug Slug de la page
     * @return string URL propre
     */
    public function generateUrl($slug) {
        $basePath = getBasePath();
        return rtrim($basePath, '/') . '/' . $slug;
    }
}

