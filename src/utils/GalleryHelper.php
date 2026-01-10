<?php
/**
 * Helper pour la galerie - Génération dynamique du carousel
 */
class GalleryHelper {
    
    /**
     * Génère le HTML du carousel depuis les images du dossier gallery/
     * @param PDO|null $db Connexion à la base de données (non utilisé, conservé pour compatibilité)
     * @param string $basePath Chemin de base
     * @return string HTML du carousel
     */
    public static function generateCarousel($db = null, $basePath = '/') {
        try {
            // Définir le chemin du dossier gallery
            $galleryPath = __DIR__ . '/../../gallery/';
            
            // Liste des images à afficher dans le carousel (dans l'ordre souhaité)
            $galleryImages = [
                ['file' => 'buffer.jpg', 'title' => 'Buffer Overflow', 'description' => 'Analyse et exploitation des débordements de tampon'],
                ['file' => 'hydra.jpg', 'title' => 'Hydra', 'description' => 'Test de force brute et attaques par dictionnaire'],
                ['file' => 'script.jpg', 'title' => 'Scripts de sécurité', 'description' => 'Automatisation des tests de sécurité'],
                ['file' => 'hack.jpg', 'title' => 'Hack phishing', 'description' => 'Attaque par phishing et récupération de mots de passe'],
                ['file' => 'etudiant.jpg', 'title' => 'Salon de l\'étudiant (Paris)', 'description' => 'Salon de l\'étudiant à Paris'],
                ['file' => 'esme.jpg', 'title' => 'Présentation école ESME', 'description' => 'Présentation école ESME pour bachelor (Paris)']
            ];
            
            // Filtrer les images qui existent réellement
            $existingImages = [];
            foreach ($galleryImages as $image) {
                if (file_exists($galleryPath . $image['file'])) {
                    $existingImages[] = $image;
                }
            }
            
            if (empty($existingImages)) {
                return '<p class="gallery-empty">Aucune image dans la galerie.</p>';
            }
            
            $html = '<div class="carousel-wrapper">';
            
            // Générer les radio buttons
            $count = count($existingImages);
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
            foreach ($existingImages as $index => $image) {
                $html .= '<div class="carousel-slide">';
                $html .= '<img src="' . htmlspecialchars($basePath) . 'gallery/' . htmlspecialchars($image['file']) . '" ';
                $html .= 'alt="' . htmlspecialchars($image['title']) . '">';
                $html .= '<div class="slide-caption">';
                $html .= '<h3>' . htmlspecialchars($image['title']) . '</h3>';
                $html .= '<p>' . htmlspecialchars($image['description']) . '</p>';
                $html .= '</div>';
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
            $html .= '.carousel-track { width: ' . ($count * 100) . '%; }';
            $html .= '.carousel-slide { width: ' . (100 / $count) . '%; }';
            $html .= '</style>';
            
            return $html;
        } catch (Exception $e) {
            error_log("Erreur GalleryHelper: " . $e->getMessage());
            return '<p class="gallery-empty">Erreur lors du chargement de la galerie.</p>';
        }
    }
}

