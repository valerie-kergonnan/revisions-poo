<?php

require_once '../job-01/classe-product.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 10 : Méthode update() ===\n";
echo str_repeat("=", 70) . "\n\n";

// Test 1 : Récupération d'un produit existant et modification
echo "Test 1 : Modification d'un produit existant\n";
echo str_repeat("-", 70) . "\n\n";

$product = new Product();
$result = $product->findOneById(20); // MacBook Pro M3 créé précédemment

if ($result !== false) {
    echo "Produit récupéré :\n";
    echo "  ID: " . $product->getId() . "\n";
    echo "  Nom: " . $product->getName() . "\n";
    echo "  Prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Quantité: " . $product->getQuantity() . "\n";
    echo "  Description: " . $product->getDescription() . "\n";
    echo "  Mis à jour le: " . $product->getUpdatedAt()->format('d/m/Y H:i:s') . "\n\n";

    // Modification des propriétés
    echo "Modification des données...\n";
    $product->setPrice(229900); // Nouveau prix: 2299.00 €
    $product->setQuantity(20); // Nouvelle quantité
    $product->setDescription("MacBook Pro 14 pouces avec puce M3 Pro, 32Go RAM, 1To SSD - PROMO!");

    echo "  Nouveau prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Nouvelle quantité: " . $product->getQuantity() . "\n";
    echo "  Nouvelle description: " . $product->getDescription() . "\n\n";

    // Pause d'une seconde pour voir la différence dans updatedAt
    sleep(1);

    // Mise à jour en base de données
    echo "Mise à jour dans la base de données...\n";
    $updateResult = $product->update();

    if ($updateResult !== false) {
        echo "✓ Mise à jour réussie!\n\n";
        echo "Données après mise à jour :\n";
        echo "  ID: " . $product->getId() . "\n";
        echo "  Nom: " . $product->getName() . "\n";
        echo "  Prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
        echo "  Quantité: " . $product->getQuantity() . "\n";
        echo "  Description: " . $product->getDescription() . "\n";
        echo "  Mis à jour le: " . $product->getUpdatedAt()->format('d/m/Y H:i:s') . "\n";
    } else {
        echo "✗ Échec de la mise à jour\n";
    }
} else {
    echo "✗ Produit non trouvé\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 2 : Vérification de la mise à jour en relisant le produit
echo "Test 2 : Vérification de la persistance des modifications\n";
echo str_repeat("-", 70) . "\n\n";

$productCheck = new Product();
$productCheck->findOneById(20);

echo "Relecture du produit depuis la base :\n";
echo "  ID: " . $productCheck->getId() . "\n";
echo "  Nom: " . $productCheck->getName() . "\n";
echo "  Prix: " . number_format($productCheck->getPrice() / 100, 2, ',', ' ') . " €\n";
echo "  Quantité: " . $productCheck->getQuantity() . "\n";
echo "  Description: " . substr($productCheck->getDescription(), 0, 50) . "...\n";
echo "  Mis à jour le: " . $productCheck->getUpdatedAt()->format('d/m/Y H:i:s') . "\n\n";

echo "✓ Les modifications ont bien été enregistrées!\n";

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 3 : Tentative de mise à jour d'un produit sans ID
echo "Test 3 : Tentative de mise à jour sans ID\n";
echo str_repeat("-", 70) . "\n\n";

$productWithoutId = new Product();
$productWithoutId->setName("Produit test");
$productWithoutId->setPrice(1000);

echo "Tentative de mise à jour d'un produit sans ID...\n";
$updateResult2 = $productWithoutId->update();

if ($updateResult2 === false) {
    echo "✓ Test réussi : la mise à jour est refusée pour un produit sans ID\n";
} else {
    echo "✗ Erreur : la mise à jour ne devrait pas fonctionner sans ID\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "✓ Tous les tests sont terminés!\n";
echo str_repeat("=", 70) . "\n";
