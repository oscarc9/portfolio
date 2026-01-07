<?php
// Charge la configuration des chemins si elle n'est pas déjà chargée
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../../config/paths.php';
}
if (!isset($basePath)) {
    $basePath = getBasePath();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Portfolio</title>
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>public/css/main.css">
    
    <!-- CSS spécifique à la page (si défini) -->
    <?php if (isset($pageCSS) && !empty($pageCSS)): ?>
    <link rel="stylesheet" href="<?php echo $basePath; ?>public/css/pages/<?php echo $pageCSS; ?>">
    <?php endif; ?>
    
    <!-- Fonts & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
</head>
<body>

