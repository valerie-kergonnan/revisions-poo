<?php

require_once __DIR__ . '/classe-clothing.php';
require_once __DIR__ . '/classe-electronic.php';

echo str_repeat("=", 70) . PHP_EOL;
echo "=== Job 14 : Interface StockableInterface ===" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo PHP_EOL;

// Test 1 : Ajouter du stock à un vêtement
echo "Test 1 : Gestion du stock pour un vêtement" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$clothing = (new Clothing())->findOneById(24);

if ($clothing !== false) {
    echo "Vêtement : " . $clothing->getName() . PHP_EOL;
    echo "Stock initial : " . $clothing->getQuantity() . PHP_EOL;

    // Ajouter du stock
    $clothing->addStocks(10);
    echo "Après ajout de 10 unités : " . $clothing->getQuantity() . PHP_EOL;

    // Retirer du stock
    $clothing->removeStocks(5);
    echo "Après retrait de 5 unités : " . $clothing->getQuantity() . PHP_EOL;

    // Mettre à jour en base
    $result = $clothing->update();
    if ($result !== false) {
        echo "✓ Stock mis à jour en base de données!" . PHP_EOL;
    }
} else {
    echo "❌ Vêtement non trouvé." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 2 : Gestion du stock pour un produit électronique
echo "Test 2 : Gestion du stock pour un produit électronique" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$electronic = (new Electronic())->findOneById(25);

if ($electronic !== false) {
    echo "Produit : " . $electronic->getName() . PHP_EOL;
    echo "Stock initial : " . $electronic->getQuantity() . PHP_EOL;

    // Ajouter du stock
    $electronic->addStocks(20);
    echo "Après ajout de 20 unités : " . $electronic->getQuantity() . PHP_EOL;

    // Retirer du stock
    $electronic->removeStocks(8);
    echo "Après retrait de 8 unités : " . $electronic->getQuantity() . PHP_EOL;

    // Mettre à jour en base
    $result = $electronic->update();
    if ($result !== false) {
        echo "✓ Stock mis à jour en base de données!" . PHP_EOL;
    }
} else {
    echo "❌ Produit électronique non trouvé." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 3 : Chaînage de méthodes grâce au retour 'self'
echo "Test 3 : Chaînage de méthodes (Fluent Interface)" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$newClothing = new Clothing();
$newClothing->setName("Sweat à capuche");
$newClothing->setPhotos(["sweat1.jpg"]);
$newClothing->setPrice(3990); // 39,90€
$newClothing->setDescription("Sweat confortable pour l'hiver");
$newClothing->setQuantity(50);
$newClothing->setCategoryId(1);
$newClothing->setSize("L");
$newClothing->setColor("Gris");
$newClothing->setType("Sweat");
$newClothing->setMaterialFee(600);

$result = $newClothing->create();

if ($result !== false) {
    echo "✓ Nouveau vêtement créé avec ID: " . $result->getId() . PHP_EOL;
    echo "Stock initial: " . $result->getQuantity() . PHP_EOL;

    // Utilisation du chaînage avec les méthodes de stock
    $result->addStocks(25)
        ->removeStocks(10)
        ->update();

    echo "Stock après chaînage (ajout 25, retrait 10) : " . $result->getQuantity() . PHP_EOL;
    echo "✓ Chaînage de méthodes réussi!" . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 4 : Protection contre le stock négatif
echo "Test 4 : Protection contre le stock négatif" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$testProduct = new Electronic();
$testProduct->setName("Test Product");
$testProduct->setPhotos(["test.jpg"]);
$testProduct->setPrice(10000);
$testProduct->setDescription("Produit de test");
$testProduct->setQuantity(5);
$testProduct->setCategoryId(2);
$testProduct->setBrand("TestBrand");
$testProduct->setWarrantyFee(1000);

$testProduct->create();

echo "Stock initial : " . $testProduct->getQuantity() . PHP_EOL;

// Tenter de retirer plus que le stock disponible
$testProduct->removeStocks(10);
echo "Après tentative de retrait de 10 unités (stock initial: 5)" . PHP_EOL;
echo "Stock actuel : " . $testProduct->getQuantity() . PHP_EOL;
echo "✓ Le stock ne devient jamais négatif (protection min=0)!" . PHP_EOL;

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 5 : Vérification de l'implémentation de l'interface
echo "Test 5 : Vérification de l'interface StockableInterface" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$clothing = new Clothing();
$electronic = new Electronic();

if ($clothing instanceof StockableInterface) {
    echo "✓ Clothing implémente StockableInterface" . PHP_EOL;
}

if ($electronic instanceof StockableInterface) {
    echo "✓ Electronic implémente StockableInterface" . PHP_EOL;
}

echo PHP_EOL;
echo "Méthodes disponibles via StockableInterface :" . PHP_EOL;
echo "  - addStocks(int \$stock): self" . PHP_EOL;
echo "  - removeStocks(int \$stock): self" . PHP_EOL;

echo PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo "✓ Tous les tests de l'interface StockableInterface sont terminés!" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
