<?php
/**
 * Configuration des chemins relatifs
 * Détermine automatiquement le chemin de base selon l'emplacement du fichier
 */

// Détermine le chemin de base automatiquement
function getBasePath() {
    // Chemin absolu de la racine du projet
    $projectRoot = realpath(__DIR__ . '/..');
    
    // Chemin absolu du script actuel
    $scriptPath = realpath($_SERVER['SCRIPT_FILENAME']);
    
    // Chemin relatif depuis le script jusqu'à la racine
    $relativePath = str_replace($projectRoot, '', dirname($scriptPath));
    
    // Si on est à la racine
    if (empty($relativePath) || $relativePath === '/' || $relativePath === '\\') {
        return '';
    }
    
    // Compte le nombre de niveaux à remonter
    $levels = substr_count($relativePath, DIRECTORY_SEPARATOR);
    if ($levels > 0) {
        return str_repeat('../', $levels);
    }
    
    return '';
}

// Définit la variable globale $basePath si elle n'existe pas
if (!isset($basePath)) {
    $basePath = getBasePath();
}

