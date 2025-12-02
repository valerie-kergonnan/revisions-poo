<?php

require_once '../job-01/classe-product.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 09 : Méthode create() ===\n";
echo str_repeat("=", 70) . "\n\n";

// Test 1 : Création d'un nouveau produit
echo "Test 1 : Création d'un nouveau produit\n";
echo str_repeat("-", 70) . "\n\n";

$newProduct = new Product();
$newProduct->setName("MacBook Pro M3");
$newProduct->setPhotos(["macbook1.jpg", "macbook2.jpg", "macbook3.jpg"]);
$newProduct->setPrice(249900); // 2499.00 €
$newProduct->setDescription("MacBook Pro 14 pouces avec puce M3, 16Go RAM, 512Go SSD");
$newProduct->setQuantity(15);
$newProduct->setCategoryId(1); // Électronique

echo "Données du produit avant insertion :\n";
echo "  ID: " . ($newProduct->getId() ?? 'null') . "\n";
echo "  Nom: " . $newProduct->getName() . "\n";
echo "  Prix: " . number_format($newProduct->getPrice() / 100, 2, ',', ' ') . " €\n";
echo "  Quantité: " . $newProduct->getQuantity() . "\n";
echo "  Category ID: " . $newProduct->getCategoryId() . "\n\n";

echo "Insertion dans la base de données...\n";
$result = $newProduct->create();

if ($result !== false) {
    echo "✓ Insertion réussie!\n\n";
    echo "Données du produit après insertion :\n";
    echo "  ID généré: " . $newProduct->getId() . "\n";
    echo "  Nom: " . $newProduct->getName() . "\n";
    echo "  Prix: " . number_format($newProduct->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Description: " . $newProduct->getDescription() . "\n";
    echo "  Quantité: " . $newProduct->getQuantity() . "\n";
    echo "  Category ID: " . $newProduct->getCategoryId() . "\n";
    echo "  Photos: " . implode(', ', $newProduct->getPhotos()) . "\n";
    echo "  Créé le: " . $newProduct->getCreatedAt()->format('d/m/Y H:i:s') . "\n";
    echo "  Mis à jour le: " . $newProduct->getUpdatedAt()->format('d/m/Y H:i:s') . "\n";
} else {
    echo "✗ Échec de l'insertion\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 2 : Création d'un deuxième produit
echo "Test 2 : Création d'un autre produit\n";
echo str_repeat("-", 70) . "\n\n";

$newProduct2 = new Product();
$newProduct2->setName("Chaussures de running");
$newProduct2->setPhotos(["running1.jpg", "running2.jpg"]);
$newProduct2->setPrice(12900); // 129.00 €
$newProduct2->setDescription("Chaussures de running professionnelles, légères et confortables");
$newProduct2->setQuantity(40);
$newProduct2->setCategoryId(5); // Sports & Loisirs

echo "Insertion du produit : " . $newProduct2->getName() . "\n";
$result2 = $newProduct2->create();

if ($result2 !== false) {
    echo "✓ Insertion réussie! ID généré: " . $newProduct2->getId() . "\n";
} else {
    echo "✗ Échec de l'insertion\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 3 : Vérification de l'insertion en récupérant le produit
echo "Test 3 : Vérification des produits créés\n";
echo str_repeat("-", 70) . "\n\n";

$productChecker = new Product();
$allProducts = $productChecker->findAll();

echo "Nombre total de produits dans la base : " . count($allProducts) . "\n\n";

// Recherche des 2 derniers produits créés
$lastProducts = array_slice($allProducts, -2);
echo "Les 2 derniers produits créés :\n\n";

foreach ($lastProducts as $index => $product) {
    echo ($index + 1) . ". " . $product->getName() . " (ID: " . $product->getId() . ")\n";
    echo "   Prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "   Quantité: " . $product->getQuantity() . "\n\n";
}

echo str_repeat("=", 70) . "\n";
echo "✓ Tests terminés avec succès!\n";
echo str_repeat("=", 70) . "\n";
