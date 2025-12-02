<?php

require_once '../job-01/classe-product.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 07 : Méthode findOneById() ===\n";
echo str_repeat("=", 70) . "\n\n";

// Test 1 : Recherche d'un produit existant (ID = 5)
echo "Test 1 : Recherche du produit avec l'ID 5\n";
echo str_repeat("-", 70) . "\n";

$product1 = new Product();
$result1 = $product1->findOneById(5);

if ($result1 !== false) {
    echo "✓ Produit trouvé!\n\n";
    echo "Détails du produit :\n";
    echo "  ID: " . $product1->getId() . "\n";
    echo "  Nom: " . $product1->getName() . "\n";
    echo "  Prix: " . number_format($product1->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Description: " . $product1->getDescription() . "\n";
    echo "  Quantité: " . $product1->getQuantity() . "\n";
    echo "  Category ID: " . $product1->getCategoryId() . "\n";
    echo "  Photos: " . implode(', ', $product1->getPhotos()) . "\n";
    echo "  Créé le: " . $product1->getCreatedAt()->format('d/m/Y H:i:s') . "\n";
    echo "  Mis à jour le: " . $product1->getUpdatedAt()->format('d/m/Y H:i:s') . "\n";
} else {
    echo "✗ Produit non trouvé\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 2 : Recherche d'un produit existant (ID = 10)
echo "Test 2 : Recherche du produit avec l'ID 10\n";
echo str_repeat("-", 70) . "\n";

$product2 = new Product();
$result2 = $product2->findOneById(10);

if ($result2 !== false) {
    echo "✓ Produit trouvé!\n\n";
    echo "Détails du produit :\n";
    echo "  ID: " . $product2->getId() . "\n";
    echo "  Nom: " . $product2->getName() . "\n";
    echo "  Prix: " . number_format($product2->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Description: " . $product2->getDescription() . "\n";
    echo "  Quantité: " . $product2->getQuantity() . "\n";
} else {
    echo "✗ Produit non trouvé\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 3 : Recherche d'un produit inexistant (ID = 999)
echo "Test 3 : Recherche du produit avec l'ID 999 (inexistant)\n";
echo str_repeat("-", 70) . "\n";

$product3 = new Product();
$result3 = $product3->findOneById(999);

if ($result3 !== false) {
    echo "✓ Produit trouvé: " . $product3->getName() . "\n";
} else {
    echo "✓ Test réussi : false retourné pour un produit inexistant\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 4 : Vérification que l'instance retournée est bien celle en cours
echo "Test 4 : Vérification de l'instance retournée\n";
echo str_repeat("-", 70) . "\n";

$product4 = new Product();
$result4 = $product4->findOneById(1);

if ($result4 === $product4) {
    echo "✓ L'instance retournée est bien l'instance courante\n";
    echo "  Produit: " . $product4->getName() . "\n";
} else {
    echo "✗ Erreur : l'instance retournée n'est pas l'instance courante\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "✓ Tous les tests sont terminés!\n";
echo str_repeat("=", 70) . "\n";
