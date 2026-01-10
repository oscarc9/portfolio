<?php
/**
 * Configuration des routes statiques
 * Les routes dynamiques sont gérées via la base de données (table pages)
 */

return [
    // Routes statiques principales
    'accueil' => [
        'controller' => null,
        'file' => 'main/accueil.php'
    ],
    'admin' => [
        'controller' => 'AuthController',
        'method' => 'dashboard'
    ],
    'admin/login' => [
        'controller' => 'AuthController',
        'method' => 'login'
    ],
    'admin/logout' => [
        'controller' => 'AuthController',
        'method' => 'logout'
    ]
];

