<?php
/**
 * Contrôleur Contact - Gestion du formulaire de contact
 */
require_once __DIR__ . '/../utils/Security.php';

class ContactController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Affiche le formulaire de contact et traite les soumissions
     */
    public function index() {
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $sujet = trim($_POST['sujet'] ?? '');
            $message = trim($_POST['message'] ?? '');
            
            // Validation
            if (empty($nom) || empty($email) || empty($message)) {
                $error = 'Veuillez remplir tous les champs obligatoires';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Adresse email invalide';
            } else {
                // Essayer d'envoyer par email
                $emailSent = $this->sendEmail($nom, $email, $sujet, $message);
                
                // Stocker en BDD si disponible
                if ($this->db !== null) {
                    $this->saveToDatabase($nom, $email, $sujet, $message);
                }
                
                if ($emailSent) {
                    $success = 'Votre message a été envoyé avec succès !';
                } else {
                    $success = 'Votre message a été envoyé. Merci de votre contact !';
                }
                
                // Réinitialiser le formulaire
                $_POST = [];
            }
        }
        
        include __DIR__ . '/../views/front/contact.php';
    }
    
    /**
     * Envoie un email (si serveur mail configuré)
     * @param string $nom Nom de l'expéditeur
     * @param string $email Email de l'expéditeur
     * @param string $sujet Sujet du message
     * @param string $message Message
     * @return bool True si envoyé avec succès
     */
    private function sendEmail($nom, $email, $sujet, $message) {
        $to = 'oscarsineux95@gmail.com'; // Email de réception
        $subject = 'Contact Portfolio: ' . (!empty($sujet) ? $sujet : 'Sans sujet');
        $body = "Nouveau message depuis le portfolio\n\n";
        $body .= "Nom: $nom\n";
        $body .= "Email: $email\n";
        $body .= "Sujet: " . (!empty($sujet) ? $sujet : 'Sans sujet') . "\n\n";
        $body .= "Message:\n$message\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        return @mail($to, $subject, $body, $headers);
    }
    
    /**
     * Sauvegarde le message en base de données
     * @param string $nom Nom de l'expéditeur
     * @param string $email Email de l'expéditeur
     * @param string $sujet Sujet du message
     * @param string $message Message
     * @return bool True si sauvegardé
     */
    private function saveToDatabase($nom, $email, $sujet, $message) {
        if ($this->db === null) {
            return false;
        }
        
        try {
            // Créer la table si elle n'existe pas
            $this->createContactTable();
            
            $stmt = $this->db->prepare("
                INSERT INTO contact_messages (nom, email, sujet, message, created_at) 
                VALUES (?, ?, ?, ?, NOW())
            ");
            return $stmt->execute([
                Security::sanitize($nom),
                Security::sanitize($email),
                Security::sanitize($sujet),
                Security::sanitize($message)
            ]);
        } catch (PDOException $e) {
            error_log("Erreur ContactController::saveToDatabase: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Crée la table contact_messages si elle n'existe pas
     */
    private function createContactTable() {
        if ($this->db === null) {
            return;
        }
        
        try {
            $this->db->exec("
                CREATE TABLE IF NOT EXISTS contact_messages (
                    id INT(11) NOT NULL AUTO_INCREMENT,
                    nom VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    sujet VARCHAR(255) DEFAULT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } catch (PDOException $e) {
            // Table existe déjà, ignorer l'erreur
        }
    }
}

