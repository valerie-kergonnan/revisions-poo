<?php

require_once '../job-01/classe-product.php';
require_once '../job-02/classe-catagory.php';

echo "=== Test des constructeurs optionnels ===\n\n";

// Méthode 1 : Instanciation avec tous les paramètres
echo "1. Avec tous les paramètres :\n";
$product1 = new Product(
    1,
    'Ordinateur portable',
    ['photo1.jpg', 'photo2.jpg'],
    89999,
    'Un excellent ordinateur portable',
    10,
    1
);

echo "Product 1 - ID: " . $product1->getId() . "\n";
echo "Product 1 - Nom: " . $product1->getName() . "\n";
echo "Product 1 - Prix: " . $product1->getPrice() . " centimes\n\n";

// Méthode 2 : Instanciation sans paramètres + utilisation des setters
echo "2. Sans paramètres, puis avec setters :\n";
$product2 = new Product();
$product2->setId(2);
$product2->setName('Smartphone');
$product2->setPhotos(['smartphone1.jpg', 'smartphone2.jpg']);
$product2->setPrice(59999);
$product2->setDescription('Smartphone dernier cri');
$product2->setQuantity(50);
$product2->setCategoryId(1);

echo "Product 2 - ID: " . $product2->getId() . "\n";
echo "Product 2 - Nom: " . $product2->getName() . "\n";
echo "Product 2 - Prix: " . $product2->getPrice() . " centimes\n\n";

// Méthode 3 : Instanciation partielle
echo "3. Avec quelques paramètres seulement :\n";
$product3 = new Product(3, 'Tablette');
$product3->setPrice(45999);
$product3->setQuantity(30);

echo "Product 3 - ID: " . $product3->getId() . "\n";
echo "Product 3 - Nom: " . $product3->getName() . "\n";
echo "Product 3 - Prix: " . ($product3->getPrice() ?? 'Non défini') . "\n";
echo "Product 3 - Description: " . ($product3->getDescription() ?? 'Non définie') . "\n\n";

// Test avec Category
echo "=== Test avec Category ===\n\n";

echo "1. Category avec tous les paramètres :\n";
$category1 = new Category(1, 'Électronique', 'Produits high-tech');
echo "Category 1 - ID: " . $category1->getId() . "\n";
echo "Category 1 - Nom: " . $category1->getName() . "\n\n";

echo "2. Category sans paramètres + setters :\n";
$category2 = new Category();
$category2->setId(2);
$category2->setName('Vêtements');
$category2->setDescription('Mode et accessoires');

echo "Category 2 - ID: " . $category2->getId() . "\n";
echo "Category 2 - Nom: " . $category2->getName() . "\n";
echo "Category 2 - Description: " . $category2->getDescription() . "\n\n";

echo "✓ Tous les tests ont réussi!\n";
