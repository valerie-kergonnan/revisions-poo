<?php

require_once '../job-01/classe-product.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 08 : Méthode findAll() ===\n";
echo str_repeat("=", 70) . "\n\n";

// Création d'une instance pour appeler la méthode
$productInstance = new Product();

// Récupération de tous les produits
echo "Récupération de tous les produits de la base de données...\n\n";
$products = $productInstance->findAll();

if (count($products) > 0) {
    echo "✓ " . count($products) . " produit(s) récupéré(s)\n\n";
    echo str_repeat("=", 70) . "\n\n";

    foreach ($products as $index => $product) {
        echo "Produit #" . ($index + 1) . "\n";
        echo str_repeat("-", 70) . "\n";
        echo "  ID: " . $product->getId() . "\n";
        echo "  Nom: " . $product->getName() . "\n";
        echo "  Prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
        echo "  Description: " . substr($product->getDescription(), 0, 50) . "...\n";
        echo "  Quantité: " . $product->getQuantity() . "\n";
        echo "  Category ID: " . $product->getCategoryId() . "\n";
        echo "  Photos: " . implode(', ', $product->getPhotos()) . "\n";
        echo "\n";
    }

    echo str_repeat("=", 70) . "\n\n";

    // Statistiques
    echo "Statistiques :\n";
    echo str_repeat("-", 70) . "\n";

    // Calcul du prix total de tous les produits en stock
    $totalValue = 0;
    $totalQuantity = 0;
    foreach ($products as $product) {
        $totalValue += $product->getPrice() * $product->getQuantity();
        $totalQuantity += $product->getQuantity();
    }

    echo "  Nombre total de produits: " . count($products) . "\n";
    echo "  Quantité totale en stock: " . $totalQuantity . "\n";
    echo "  Valeur totale du stock: " . number_format($totalValue / 100, 2, ',', ' ') . " €\n\n";

    // Groupement par catégorie
    echo "Répartition par catégorie :\n";
    $categoryCounts = [];
    foreach ($products as $product) {
        $catId = $product->getCategoryId();
        if (!isset($categoryCounts[$catId])) {
            $categoryCounts[$catId] = 0;
        }
        $categoryCounts[$catId]++;
    }

    foreach ($categoryCounts as $catId => $count) {
        echo "  Catégorie ID $catId: $count produit(s)\n";
    }

    echo "\n" . str_repeat("=", 70) . "\n";
    echo "✓ Récupération terminée avec succès!\n";
    echo str_repeat("=", 70) . "\n";
} else {
    echo "⚠ Aucun produit trouvé dans la base de données\n";
}
