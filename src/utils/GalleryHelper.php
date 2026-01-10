<?php
/**
 * Helper pour la galerie - Génération dynamique du carousel
 */
class GalleryHelper {
    
    /**
     * Génère le HTML du carousel depuis les médias de la BDD
     * @param PDO $db Connexion à la base de données
     * @param string $basePath Chemin de base
     * @return string HTML du carousel
     */
    public static function generateCarousel($db, $basePath) {
        require_once __DIR__ . '/../models/Media.php';
        
        try {
            $mediaModel = new Media($db);
            $images = $mediaModel->findAll('image');
            
            if (empty($images)) {
                return '<p class="gallery-empty">Aucune image dans la galerie.</p>';
            }
            
            $html = '<div class="carousel-wrapper">';
            
            // Générer les radio buttons
            $count = count($images);
            for ($i = 1; $i <= $count; $i++) {
                $checked = $i === 1 ? ' checked' : '';
                $html .= '<input type="radio" name="carousel" id="carousel-' . $i . '" class="carousel-radio"' . $checked . '>';
            }
            
            // Générer les flèches précédentes
            for ($i = 1; $i <= $count; $i++) {
                $prev = $i === 1 ? $count : $i - 1;
                $html .= '<label for="carousel-' . $prev . '" class="carousel-arrow carousel-prev carousel-prev-' . $i . '">';
                $html .= '<i class="ri-arrow-left-s-line"></i>';
                $html .= '</label>';
            }
            
            // Container du carousel
            $html .= '<div class="carousel-container">';
            $html .= '<div class="carousel-track" data-count="' . $count . '">';
            
            // Générer les slides
            foreach ($images as $index => $image) {
                $html .= '<div class="carousel-slide">';
                $html .= '<img src="' . $basePath . 'public/uploads/' . htmlspecialchars($image['fichier']) . '" ';
                $html .= 'alt="' . htmlspecialchars($image['fichier']) . '">';
                $html .= '</div>';
            }
            
            $html .= '</div>'; // carousel-track
            $html .= '</div>'; // carousel-container
            
            // Générer les flèches suivantes
            for ($i = 1; $i <= $count; $i++) {
                $next = $i === $count ? 1 : $i + 1;
                $html .= '<label for="carousel-' . $next . '" class="carousel-arrow carousel-next carousel-next-' . $i . '">';
                $html .= '<i class="ri-arrow-right-s-line"></i>';
                $html .= '</label>';
            }
            
            $html .= '</div>'; // carousel-wrapper
            
            // Ajouter le CSS dynamique pour le carousel
            $html .= '<style>';
            for ($i = 1; $i <= $count; $i++) {
                $offset = ($i - 1) * 100;
                $html .= '#carousel-' . $i . ':checked ~ .carousel-container .carousel-track {';
                $html .= 'transform: translateX(-' . ($offset / $count) . '%);';
                $html .= '}';
                
                $html .= '#carousel-' . $i . ':checked ~ .carousel-prev-' . $i . ',';
                $html .= '#carousel-' . $i . ':checked ~ .carousel-next-' . $i . ' {';
                $html .= 'display: flex;';
                $html .= '}';
            }
            $html .= '</style>';
            
            return $html;
        } catch (Exception $e) {
            error_log("Erreur GalleryHelper: " . $e->getMessage());
            return '<p class="gallery-empty">Erreur lors du chargement de la galerie.</p>';
        }
    }
}

