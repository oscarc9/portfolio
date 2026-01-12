<?php
/**
 * Helper pour l'envoi d'emails via SMTP
 * 
 * NOTE: La configuration SMTP se fait dans Cloudways
 * Cette classe utilise la fonction mail() native de PHP qui utilise
 * automatiquement la configuration SMTP de Cloudways
 */
class EmailHelper {
    private static $config = null;
    
    /**
     * Charge la configuration email
     */
    private static function loadConfig() {
        if (self::$config === null) {
            $configPath = __DIR__ . '/../../config/email.php';
            if (file_exists($configPath)) {
                self::$config = require $configPath;
            } else {
                throw new Exception("Fichier de configuration email introuvable");
            }
        }
        return self::$config;
    }
    
    /**
     * Envoie un email via SMTP (utilise la config Cloudways)
     * @param string $to Email du destinataire
     * @param string $subject Sujet de l'email
     * @param string $body Corps de l'email (texte)
     * @param string $fromEmail Email de l'expéditeur (optionnel)
     * @param string $fromName Nom de l'expéditeur (optionnel)
     * @param string $replyTo Email pour répondre (optionnel)
     * @return bool True si envoyé avec succès
     */
    public static function send($to, $subject, $body, $fromEmail = null, $fromName = null, $replyTo = null) {
        try {
            $config = self::loadConfig();
            
            $fromEmail = $fromEmail ?? $config['from_email'];
            $fromName = $fromName ?? $config['from_name'];
            $replyToEmail = $replyTo ?? $config['reply_to'];
            
            // Headers pour mail() - Cloudways utilisera sa config SMTP
            $headers = "From: $fromName <$fromEmail>\r\n";
            $headers .= "Reply-To: $replyToEmail\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            
            return @mail($to, $subject, $body, $headers);
        } catch (Exception $e) {
            error_log("Erreur EmailHelper::send: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Envoie un email de contact (message reçu)
     * @param string $nom Nom de l'expéditeur
     * @param string $email Email de l'expéditeur
     * @param string $sujet Sujet du message
     * @param string $message Message
     * @return bool True si envoyé avec succès
     */
    public static function sendContactMessage($nom, $email, $sujet, $message) {
        $config = self::loadConfig();
        $to = $config['contact_email'];
        
        $subject = 'Contact Portfolio: ' . (!empty($sujet) ? $sujet : 'Sans sujet');
        $body = "Nouveau message depuis le portfolio\n\n";
        $body .= "Nom: $nom\n";
        $body .= "Email: $email\n";
        $body .= "Sujet: " . (!empty($sujet) ? $sujet : 'Sans sujet') . "\n\n";
        $body .= "Message:\n$message\n";
        
        return self::send($to, $subject, $body, $config['from_email'], $config['from_name'], $email);
    }
    
    /**
     * Envoie un email de confirmation à l'utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $sujet Sujet du message original
     * @return bool True si envoyé avec succès
     */
    public static function sendConfirmation($nom, $email, $sujet) {
        $config = self::loadConfig();
        
        $subject = 'Confirmation de réception - Portfolio';
        $body = "Bonjour $nom,\n\n";
        $body .= "Nous avons bien reçu votre message";
        if (!empty($sujet)) {
            $body .= " concernant : \"$sujet\"";
        }
        $body .= ".\n\n";
        $body .= "Nous vous répondrons dans les plus brefs délais.\n\n";
        $body .= "Cordialement,\n";
        $body .= "Oscar Sineux\n";
        $body .= "Portfolio";
        
        return self::send($email, $subject, $body);
    }
    
    /**
     * Envoie une réponse à un utilisateur
     * @param string $nom Nom de l'utilisateur
     * @param string $email Email de l'utilisateur
     * @param string $sujetOriginal Sujet du message original
     * @param string $reponse Texte de la réponse
     * @return bool True si envoyé avec succès
     */
    public static function sendReply($nom, $email, $sujetOriginal, $reponse) {
        $config = self::loadConfig();
        
        $subject = 'Re: ' . (!empty($sujetOriginal) ? $sujetOriginal : 'Votre message');
        $body = "Bonjour $nom,\n\n";
        $body .= "Merci pour votre message";
        if (!empty($sujetOriginal)) {
            $body .= " concernant : \"$sujetOriginal\"";
        }
        $body .= ".\n\n";
        $body .= "Voici notre réponse :\n\n";
        $body .= "$reponse\n\n";
        $body .= "Cordialement,\n";
        $body .= "Oscar Sineux";
        
        return self::send($email, $subject, $body);
    }
}
?>

