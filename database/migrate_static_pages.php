<?php
/**
 * Script de migration - Convertit les pages statiques en entrées BDD
 * 
 * Usage: php database/migrate_static_pages.php
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/models/Page.php';
require_once __DIR__ . '/../src/models/Menu.php';

try {
    $db = getDatabaseConnection();
    $pageModel = new Page($db);
    $menuModel = new Menu($db);
    
    echo "Début de la migration des pages statiques...\n\n";
    
    // Mapping des pages statiques vers la BDD
    $staticPages = [
        [
            'titre' => 'Accueil',
            'slug' => 'accueil',
            'contenu' => 'Page d\'accueil du portfolio',
            'ordre' => 1
        ],
        [
            'titre' => 'Présentation BTS SIO',
            'slug' => 'bts',
            'contenu' => 'Présentation de la formation BTS SIO',
            'ordre' => 2
        ],
        [
            'titre' => 'Mon profil',
            'slug' => 'mon-profil',
            'contenu' => 'Présentation personnelle',
            'ordre' => 3
        ],
        [
            'titre' => 'Compétences techniques',
            'slug' => 'competences-techniques',
            'contenu' => 'Mes compétences techniques',
            'ordre' => 4
        ],
        [
            'titre' => 'Soft skills',
            'slug' => 'soft-skills',
            'contenu' => 'Mes compétences comportementales',
            'ordre' => 5
        ],
        [
            'titre' => 'Épreuve E5',
            'slug' => 'epreuve-e5',
            'contenu' => 'Présentation de l\'épreuve E5',
            'ordre' => 6
        ],
        [
            'titre' => 'Épreuve E6',
            'slug' => 'epreuve-e6',
            'contenu' => 'Présentation de l\'épreuve E6',
            'ordre' => 7
        ],
        [
            'titre' => 'Ma passion',
            'slug' => 'passion',
            'contenu' => 'Ma passion pour la cybersécurité',
            'ordre' => 8
        ],
        [
            'titre' => 'Contact',
            'slug' => 'contact',
            'contenu' => 'Formulaire de contact',
            'ordre' => 9
        ]
    ];
    
    $created = 0;
    $skipped = 0;
    
    foreach ($staticPages as $pageData) {
        // Vérifier si la page existe déjà
        $existing = $pageModel->findBySlug($pageData['slug']);
        
        if ($existing) {
            echo "Page '{$pageData['titre']}' existe déjà (slug: {$pageData['slug']})\n";
            $skipped++;
            continue;
        }
        
        // Créer la page
        $pageId = $pageModel->create($pageData);
        
        if ($pageId) {
            echo "✓ Page créée: {$pageData['titre']} (ID: $pageId)\n";
            $created++;
        } else {
            echo "✗ Erreur lors de la création de: {$pageData['titre']}\n";
        }
    }
    
    echo "\nMigration terminée:\n";
    echo "- Pages créées: $created\n";
    echo "- Pages ignorées (déjà existantes): $skipped\n";
    echo "\nVous pouvez maintenant gérer ces pages depuis le back-office.\n";
    
} catch (Exception $e) {
    echo "ERREUR: " . $e->getMessage() . "\n";
    exit(1);
}

