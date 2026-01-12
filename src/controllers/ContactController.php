<?php
/**
 * Contrôleur Contact - Gestion du formulaire de contact
 */
require_once __DIR__ . '/../utils/Security.php';
require_once __DIR__ . '/../utils/EmailHelper.php';

// S'assurer que getBasePath() est disponible
if (!function_exists('getBasePath')) {
    require_once __DIR__ . '/../../config/paths.php';
}

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
                // Envoyer le message par email (SMTP)
                $emailSent = EmailHelper::sendContactMessage($nom, $email, $sujet, $message);
                
                // Envoyer l'accusé de réception à l'utilisateur
                EmailHelper::sendConfirmation($nom, $email, $sujet);
                
                // Stocker en BDD si disponible
                if ($this->db !== null) {
                    $this->saveToDatabase($nom, $email, $sujet, $message);
                }
                
                if ($emailSent) {
                    $success = 'Votre message a été envoyé avec succès ! Vous allez recevoir un email de confirmation.';
                } else {
                    $success = 'Votre message a été enregistré. Merci de votre contact !';
                }
                
                // Réinitialiser le formulaire
                $_POST = [];
            }
        }
        
        include __DIR__ . '/../views/front/contact.php';
    }
    
    /**
     * Liste tous les messages de contact (admin)
     */
    public function listMessages() {
        Security::requireAdmin();
        
        $messages = [];
        if ($this->db !== null) {
            try {
                $this->createContactTable();
                $stmt = $this->db->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
                $messages = $stmt->fetchAll();
            } catch (PDOException $e) {
                error_log("Erreur ContactController::listMessages: " . $e->getMessage());
                $messages = [];
            }
        }
        
        $pageTitle = 'Messages de contact';
        $basePath = getBasePath();
        
        include __DIR__ . '/../views/admin/contact/list.php';
    }
    
    /**
     * Affiche le formulaire de réponse et traite les réponses (admin)
     */
    public function reply() {
        Security::requireAdmin();
        
        $id = (int)($_GET['id'] ?? 0);
        $message = null;
        $error = '';
        $success = '';
        
        if ($id > 0 && $this->db !== null) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM contact_messages WHERE id = ?");
                $stmt->execute([$id]);
                $message = $stmt->fetch();
            } catch (PDOException $e) {
                error_log("Erreur ContactController::reply (récupération): " . $e->getMessage());
            }
        }
        
        if (!$message) {
            header('Location: ' . getBasePath() . 'admin/contact');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reponse = trim($_POST['reponse'] ?? '');
            
            if (empty($reponse)) {
                $error = 'Veuillez saisir une réponse';
            } else {
                // Envoyer l'email de réponse à l'utilisateur
                $emailSent = EmailHelper::sendReply(
                    $message['nom'],
                    $message['email'],
                    $message['sujet'],
                    $reponse
                );
                
                // Sauvegarder la réponse en BDD
                if ($this->db !== null) {
                    try {
                        $this->updateContactTable();
                        $stmt = $this->db->prepare("
                            UPDATE contact_messages 
                            SET reponse = ?, reponse_at = NOW(), reponse_envoyee = ? 
                            WHERE id = ?
                        ");
                        $stmt->execute([
                            Security::sanitize($reponse),
                            $emailSent ? 1 : 0,
                            $id
                        ]);
                        
                        if ($emailSent) {
                            $success = 'Réponse envoyée avec succès ! L\'utilisateur a été notifié par email.';
                        } else {
                            $success = 'Réponse sauvegardée mais l\'email n\'a pas pu être envoyé.';
                        }
                    } catch (PDOException $e) {
                        $error = 'Erreur lors de la sauvegarde de la réponse';
                        error_log("Erreur ContactController::reply (sauvegarde): " . $e->getMessage());
                    }
                }
            }
        }
        
        $pageTitle = 'Répondre au message';
        $basePath = getBasePath();
        
        include __DIR__ . '/../views/admin/contact/reply.php';
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
                    reponse TEXT DEFAULT NULL,
                    reponse_at TIMESTAMP NULL DEFAULT NULL,
                    reponse_envoyee BOOLEAN DEFAULT FALSE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } catch (PDOException $e) {
            // Table existe déjà, ignorer l'erreur
        }
    }
    
    /**
     * Met à jour la table contact_messages pour ajouter les colonnes de réponse si nécessaire
     */
    private function updateContactTable() {
        if ($this->db === null) {
            return;
        }
        
        try {
            // Vérifier si les colonnes existent déjà
            $stmt = $this->db->query("SHOW COLUMNS FROM contact_messages LIKE 'reponse'");
            if ($stmt->rowCount() == 0) {
                // Ajouter les colonnes de réponse
                $this->db->exec("
                    ALTER TABLE contact_messages 
                    ADD COLUMN reponse TEXT DEFAULT NULL,
                    ADD COLUMN reponse_at TIMESTAMP NULL DEFAULT NULL,
                    ADD COLUMN reponse_envoyee BOOLEAN DEFAULT FALSE
                ");
            }
        } catch (PDOException $e) {
            // Colonnes existent déjà ou erreur, ignorer
            error_log("Erreur updateContactTable: " . $e->getMessage());
        }
    }
}

