<?php
/**
 * Configuration des chemins relatifs
 * Détermine automatiquement le chemin de base selon l'emplacement du fichier
 */

// Détermine le chemin de base automatiquement
function getBasePath() {
    // Sur Cloudways, les fichiers sont dans public_html/ à la racine
    // Le chemin de base est simplement "/"
    
    // Vérifier si on est dans un sous-dossier (développement local)
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    
    // Extraire le chemin de base depuis REQUEST_URI
    $uri = parse_url($requestUri, PHP_URL_PATH);
    
    // Si l'URI contient /portfolio/, c'est un environnement local
    if (strpos($uri, '/portfolio/') === 0) {
        return '/portfolio/';
    }
    
    // Vérifier aussi SCRIPT_NAME pour détecter le sous-dossier
    if (strpos($scriptName, '/portfolio/') !== false) {
        return '/portfolio/';
    }
    
    // Sinon, on est à la racine (production Cloudways)
    // Le script index.php est à la racine, donc basePath = "/"
    // S'assurer qu'on retourne toujours un slash final
    return '/';
}

// Définit la variable globale $basePath si elle n'existe pas
if (!isset($basePath)) {
    $basePath = getBasePath();
}

