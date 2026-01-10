-- Portfolio CMS - Schéma de base de données
-- Création des tables pour le système CMS

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `login` VARCHAR(50) NOT NULL UNIQUE,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` VARCHAR(20) NOT NULL DEFAULT 'admin',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des pages
CREATE TABLE IF NOT EXISTS `pages` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `contenu` TEXT,
    `parent_id` INT(11) DEFAULT NULL,
    `ordre` INT(11) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_parent` (`parent_id`),
    KEY `idx_slug` (`slug`),
    CONSTRAINT `fk_pages_parent` FOREIGN KEY (`parent_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des médias (images et PDF)
CREATE TABLE IF NOT EXISTS `media` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `type` ENUM('image', 'pdf') NOT NULL,
    `fichier` VARCHAR(255) NOT NULL,
    `page_id` INT(11) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_page` (`page_id`),
    KEY `idx_type` (`type`),
    CONSTRAINT `fk_media_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table du menu
CREATE TABLE IF NOT EXISTS `menu` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `lien` VARCHAR(255) DEFAULT NULL,
    `parent_id` INT(11) DEFAULT NULL,
    `ordre` INT(11) DEFAULT 0,
    `page_id` INT(11) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_parent` (`parent_id`),
    KEY `idx_page` (`page_id`),
    KEY `idx_ordre` (`ordre`),
    CONSTRAINT `fk_menu_parent` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_menu_page` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion d'un compte administrateur par défaut
-- Mot de passe : admin123 (à changer après première connexion)
-- Hash généré avec password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO `users` (`login`, `mot_de_passe`, `role`) 
VALUES ('admin', '$2y$10$i4R0ry8Xq.qXKszYQm5NBOFfn.AgcWjfS9kn91SLvEB7Nvn1/1meK', 'admin')
ON DUPLICATE KEY UPDATE `login`=`login`;

