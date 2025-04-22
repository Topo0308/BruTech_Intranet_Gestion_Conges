CREATE TABLE `user` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(180) NOT NULL UNIQUE,
  `roles` JSON NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `solde_conges` DECIMAL(5,2) DEFAULT 0,
  `date_embauche` DATE NOT NULL,
  `manager_id` INT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`manager_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `conge` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `date_debut` DATE NOT NULL,
  `date_fin` DATE NOT NULL,
  `type` ENUM('PAYÉ', 'SANS SOLDE', 'MALADIE', 'RTT') NOT NULL,
  `statut` ENUM('EN_ATTENTE', 'VALIDÉ', 'REFUSÉ', 'ANNULE') DEFAULT 'EN_ATTENTE',
  `justificatif_filename` VARCHAR(255) NULL,
  `justificatif_size` INT NULL,
  `commentaire_employe` TEXT NULL,
  `commentaire_manager` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);

CREATE TABLE `historique_conge` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `conge_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `action` ENUM('CREATION', 'VALIDATION', 'REFUS', 'MODIFICATION', 'ANNULATION') NOT NULL,
  `details` TEXT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`conge_id`) REFERENCES `conge` (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
);