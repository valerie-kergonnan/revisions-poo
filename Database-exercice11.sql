-- Ajout des tables pour l'héritage de Product

USE `draft-shop`;

-- Table pour les vêtements (Clothing)
CREATE TABLE IF NOT EXISTS `clothing` (
    `product_id` INT PRIMARY KEY,
    `size` VARCHAR(10) NOT NULL,
    `color` VARCHAR(50) NOT NULL,
    `type` VARCHAR(50) NOT NULL,
    `material_fee` INT NOT NULL COMMENT 'Frais de matière en centimes',
    CONSTRAINT `fk_clothing_product` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour l'électronique (Electronic)
CREATE TABLE IF NOT EXISTS `electronic` (
    `product_id` INT PRIMARY KEY,
    `brand` VARCHAR(100) NOT NULL,
    `warranty_fee` INT NOT NULL COMMENT 'Frais de garantie en centimes',
    CONSTRAINT `fk_electronic_product` FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vérification
SELECT 'Tables créées avec succès' as Status;
