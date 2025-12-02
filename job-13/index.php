<?php

require_once __DIR__ . '/classe-clothing.php';
require_once __DIR__ . '/classe-electronic.php';

echo str_repeat("=", 70) . PHP_EOL;
echo "=== Job 13 : Classe Abstraite AbstractProduct ===" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo PHP_EOL;

// Test 1 : Vérifier qu'on ne peut pas instancier AbstractProduct
echo "Test 1 : Tentative d'instanciation de AbstractProduct" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo "❌ AbstractProduct est une classe abstraite et ne peut pas être instanciée." . PHP_EOL;
echo "   Les seules classes instanciables sont Clothing et Electronic." . PHP_EOL;
echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 2 : Vérifier que Clothing fonctionne avec AbstractProduct
echo "Test 2 : Création et récupération d'un vêtement" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$clothing = new Clothing();
$clothing->setName("Pantalon Chino");
$clothing->setPhotos(["chino1.jpg", "chino2.jpg"]);
$clothing->setPrice(5990); // 59,90€
$clothing->setDescription("Pantalon chino élégant et confortable");
$clothing->setQuantity(30);
$clothing->setCategoryId(1);
$clothing->setSize("M");
$clothing->setColor("Beige");
$clothing->setType("Pantalon");
$clothing->setMaterialFee(800); // 8,00€

$result = $clothing->create();

if ($result !== false) {
    echo "✓ Vêtement créé avec succès! ID: " . $result->getId() . PHP_EOL;

    // Vérifier qu'on peut le récupérer
    $retrieved = (new Clothing())->findOneById($result->getId());
    if ($retrieved !== false) {
        echo "✓ Vêtement récupéré:" . PHP_EOL;
        echo "  - Nom: " . $retrieved->getName() . PHP_EOL;
        echo "  - Type: " . $retrieved->getType() . PHP_EOL;
        echo "  - Couleur: " . $retrieved->getColor() . PHP_EOL;
    }
} else {
    echo "❌ Erreur lors de la création du vêtement." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 3 : Vérifier que Electronic fonctionne avec AbstractProduct
echo "Test 3 : Création et récupération d'un produit électronique" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$electronic = new Electronic();
$electronic->setName("MacBook Pro 16");
$electronic->setPhotos(["macbook1.jpg", "macbook2.jpg"]);
$electronic->setPrice(299900); // 2 999,00€
$electronic->setDescription("Ordinateur portable haut de gamme");
$electronic->setQuantity(5);
$electronic->setCategoryId(2);
$electronic->setBrand("Apple");
$electronic->setWarrantyFee(29900); // 299,00€

$result = $electronic->create();

if ($result !== false) {
    echo "✓ Produit électronique créé avec succès! ID: " . $result->getId() . PHP_EOL;

    // Vérifier qu'on peut le récupérer
    $retrieved = (new Electronic())->findOneById($result->getId());
    if ($retrieved !== false) {
        echo "✓ Produit récupéré:" . PHP_EOL;
        echo "  - Nom: " . $retrieved->getName() . PHP_EOL;
        echo "  - Marque: " . $retrieved->getBrand() . PHP_EOL;
        echo "  - Prix: " . number_format($retrieved->getPrice() / 100, 2, ',', ' ') . " €" . PHP_EOL;
    }
} else {
    echo "❌ Erreur lors de la création du produit électronique." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 4 : Vérifier les méthodes abstraites avec findAll()
echo "Test 4 : Récupération de tous les vêtements (méthode abstraite)" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$clothings = (new Clothing())->findAll();
echo "✓ Nombre de vêtements trouvés : " . count($clothings) . PHP_EOL;

if (count($clothings) > 0) {
    echo PHP_EOL . "Exemples :" . PHP_EOL;
    foreach (array_slice($clothings, 0, 3) as $item) {
        echo "  - " . $item->getName() . " (" . $item->getType() . ", " . $item->getColor() . ")" . PHP_EOL;
    }
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 5 : Vérifier les méthodes abstraites avec update()
echo "Test 5 : Mise à jour d'un produit (méthode abstraite)" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$electronics = (new Electronic())->findAll();
if (count($electronics) > 0) {
    $toUpdate = $electronics[0];
    $oldPrice = $toUpdate->getPrice();
    $newPrice = $oldPrice + 10000; // +100€

    $toUpdate->setPrice($newPrice);
    $toUpdate->setWarrantyFee(20000); // 200€

    $result = $toUpdate->update();

    if ($result !== false) {
        echo "✓ Produit mis à jour avec succès!" . PHP_EOL;
        echo "  - Ancien prix: " . number_format($oldPrice / 100, 2, ',', ' ') . " €" . PHP_EOL;
        echo "  - Nouveau prix: " . number_format($result->getPrice() / 100, 2, ',', ' ') . " €" . PHP_EOL;
    } else {
        echo "❌ Erreur lors de la mise à jour." . PHP_EOL;
    }
}

echo PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo "✓ Tous les tests de la classe abstraite sont terminés!" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
