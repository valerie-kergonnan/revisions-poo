-- Création de la base de données
CREATE DATABASE IF NOT EXISTS `draft-shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `draft-shop`;

-- Table CATEGORY
CREATE TABLE IF NOT EXISTS `category` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table PRODUCT
CREATE TABLE IF NOT EXISTS `product` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `photos` TEXT NOT NULL COMMENT 'JSON array of photo filenames',
    `price` INT NOT NULL COMMENT 'Price in cents',
    `description` TEXT NOT NULL,
    `quantity` INT NOT NULL DEFAULT 0,
    `category_id` INT NOT NULL,
    `createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertions dans la table CATEGORY
INSERT INTO `category` (`id`, `name`, `description`, `createdAt`, `updatedAt`) VALUES
(1, 'Électronique', 'Produits électroniques et high-tech', NOW(), NOW()),
(2, 'Vêtements', 'Mode et accessoires pour tous', NOW(), NOW()),
(3, 'Livres', 'Romans, BD, magazines et plus', NOW(), NOW()),
(4, 'Maison & Jardin', 'Tout pour votre maison et votre jardin', NOW(), NOW()),
(5, 'Sports & Loisirs', 'Équipements sportifs et loisirs créatifs', NOW(), NOW());

-- Insertions dans la table PRODUCT
INSERT INTO `product` (`name`, `photos`, `price`, `description`, `quantity`, `category_id`, `createdAt`, `updatedAt`) VALUES
-- Électronique
('Smartphone XYZ', '["smartphone1.jpg","smartphone2.jpg","smartphone3.jpg"]', 59900, 'Smartphone dernier cri avec écran OLED 6.5 pouces', 50, 1, NOW(), NOW()),
('Ordinateur portable Pro', '["laptop1.jpg","laptop2.jpg"]', 129900, 'PC portable 15 pouces, Intel i7, 16Go RAM, SSD 512Go', 25, 1, NOW(), NOW()),
('Écouteurs sans fil', '["earbuds1.jpg","earbuds2.jpg"]', 8900, 'Écouteurs Bluetooth avec réduction de bruit active', 100, 1, NOW(), NOW()),
('Tablette tactile', '["tablet1.jpg","tablet2.jpg","tablet3.jpg"]', 45900, 'Tablette 10 pouces, 128Go de stockage', 40, 1, NOW(), NOW()),

-- Vêtements
('T-shirt Premium', '["tshirt1.jpg","tshirt2.jpg"]', 2900, 'T-shirt 100% coton bio, disponible en plusieurs couleurs', 120, 2, NOW(), NOW()),
('Jean slim', '["jeans1.jpg","jeans2.jpg"]', 5900, 'Jean stretch confortable, coupe moderne', 80, 2, NOW(), NOW()),
('Veste en cuir', '["jacket1.jpg","jacket2.jpg","jacket3.jpg"]', 19900, 'Veste en cuir véritable, style motard', 30, 2, NOW(), NOW()),
('Sneakers sport', '["shoes1.jpg","shoes2.jpg"]', 7900, 'Baskets légères et respirantes', 60, 2, NOW(), NOW()),

-- Livres
('Le Seigneur des Anneaux', '["lotr1.jpg"]', 2500, 'Trilogie complète de J.R.R. Tolkien', 30, 3, NOW(), NOW()),
('Harry Potter - Collection', '["hp1.jpg","hp2.jpg"]', 4500, 'Les 7 tomes de la saga Harry Potter', 45, 3, NOW(), NOW()),
('Programmer en Python', '["python1.jpg"]', 3900, 'Guide complet pour apprendre Python', 25, 3, NOW(), NOW()),
('BD Astérix - Intégrale', '["asterix1.jpg","asterix2.jpg"]', 8900, 'Tous les albums d\'Astérix en un seul volume', 15, 3, NOW(), NOW()),

-- Maison & Jardin
('Aspirateur robot', '["vacuum1.jpg","vacuum2.jpg"]', 29900, 'Robot aspirateur intelligent avec cartographie', 35, 4, NOW(), NOW()),
('Set de casseroles', '["pans1.jpg","pans2.jpg"]', 12900, 'Set de 5 casseroles en inox de qualité professionnelle', 20, 4, NOW(), NOW()),
('Tondeuse électrique', '["mower1.jpg"]', 24900, 'Tondeuse électrique 1800W, largeur de coupe 40cm', 12, 4, NOW(), NOW()),

-- Sports & Loisirs
('Vélo VTT', '["bike1.jpg","bike2.jpg","bike3.jpg"]', 45900, 'VTT 27.5 pouces, 21 vitesses, suspension avant', 18, 5, NOW(), NOW()),
('Ballon de football', '["ball1.jpg"]', 2500, 'Ballon de football officiel, taille 5', 75, 5, NOW(), NOW()),
('Tapis de yoga', '["yoga1.jpg","yoga2.jpg"]', 3500, 'Tapis de yoga antidérapant avec sac de transport', 50, 5, NOW(), NOW()),
('Raquette de tennis', '["racket1.jpg","racket2.jpg"]', 8900, 'Raquette de tennis en graphite, poids 280g', 22, 5, NOW(), NOW());

-- Vérification des données insérées
SELECT 'Categories inserted:' as Info, COUNT(*) as Count FROM `category`
UNION ALL
SELECT 'Products inserted:' as Info, COUNT(*) as Count FROM `product`;
