-- Script SQL pour réinitialiser le mot de passe administrateur
-- Usage: Exécutez ce script dans votre base de données MySQL

-- Mettre à jour le mot de passe administrateur (mot de passe: admin123)
-- Hash généré avec: php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"

UPDATE `users` 
SET `mot_de_passe` = '$2y$10$i4R0ry8Xq.qXKszYQm5NBOFfn.AgcWjfS9kn91SLvEB7Nvn1/1meK' 
WHERE `login` = 'admin';

-- Si l'utilisateur n'existe pas, créez-le:
INSERT INTO `users` (`login`, `mot_de_passe`, `role`) 
VALUES ('admin', '$2y$10$i4R0ry8Xq.qXKszYQm5NBOFfn.AgcWjfS9kn91SLvEB7Nvn1/1meK', 'admin')
ON DUPLICATE KEY UPDATE `mot_de_passe` = VALUES(`mot_de_passe`);

-- Vérification
SELECT `id`, `login`, `role`, `created_at` FROM `users` WHERE `login` = 'admin';

