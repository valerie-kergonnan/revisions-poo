<?php

require_once 'classe-clothing.php';
require_once 'classe-electronic.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 12 : Méthodes complètes pour Clothing et Electronic ===\n";
echo str_repeat("=", 70) . "\n\n";

// Test 1 : findAll() pour Clothing
echo "Test 1 : Récupération de tous les vêtements\n";
echo str_repeat("-", 70) . "\n\n";

$clothingInstance = new Clothing();
$allClothings = $clothingInstance->findAll();

echo "✓ " . count($allClothings) . " vêtement(s) trouvé(s)\n\n";

foreach ($allClothings as $index => $clothing) {
    echo ($index + 1) . ". " . $clothing->getName() . " (ID: " . $clothing->getId() . ")\n";
    echo "   Prix: " . number_format($clothing->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "   Taille: " . $clothing->getSize() . " | Couleur: " . $clothing->getColor() . "\n";
    echo "   Type: " . $clothing->getType() . " | Frais matière: " . number_format($clothing->getMaterialFee() / 100, 2, ',', ' ') . " €\n\n";
}

echo str_repeat("-", 70) . "\n\n";

// Test 2 : findAll() pour Electronic
echo "Test 2 : Récupération de tous les produits électroniques\n";
echo str_repeat("-", 70) . "\n\n";

$electronicInstance = new Electronic();
$allElectronics = $electronicInstance->findAll();

echo "✓ " . count($allElectronics) . " produit(s) électronique(s) trouvé(s)\n\n";

foreach ($allElectronics as $index => $electronic) {
    echo ($index + 1) . ". " . $electronic->getName() . " (ID: " . $electronic->getId() . ")\n";
    echo "   Prix: " . number_format($electronic->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "   Marque: " . $electronic->getBrand() . "\n";
    echo "   Frais garantie: " . number_format($electronic->getWarrantyFee() / 100, 2, ',', ' ') . " €\n\n";
}

echo str_repeat("-", 70) . "\n\n";

// Test 3 : findOneById() pour Clothing
echo "Test 3 : Récupération d'un vêtement spécifique\n";
echo str_repeat("-", 70) . "\n\n";

if (count($allClothings) > 0) {
    $clothingId = $allClothings[0]->getId();

    $singleClothing = new Clothing();
    $result = $singleClothing->findOneById($clothingId);

    if ($result !== false) {
        echo "✓ Vêtement trouvé:\n";
        echo "  ID: " . $singleClothing->getId() . "\n";
        echo "  Nom: " . $singleClothing->getName() . "\n";
        echo "  Prix: " . number_format($singleClothing->getPrice() / 100, 2, ',', ' ') . " €\n";
        echo "  Taille: " . $singleClothing->getSize() . "\n";
        echo "  Couleur: " . $singleClothing->getColor() . "\n";
        echo "  Type: " . $singleClothing->getType() . "\n";
        echo "  Frais de matière: " . number_format($singleClothing->getMaterialFee() / 100, 2, ',', ' ') . " €\n";
    }
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 4 : findOneById() pour Electronic
echo "Test 4 : Récupération d'un produit électronique spécifique\n";
echo str_repeat("-", 70) . "\n\n";

if (count($allElectronics) > 0) {
    $electronicId = $allElectronics[0]->getId();

    $singleElectronic = new Electronic();
    $result = $singleElectronic->findOneById($electronicId);

    if ($result !== false) {
        echo "✓ Produit électronique trouvé:\n";
        echo "  ID: " . $singleElectronic->getId() . "\n";
        echo "  Nom: " . $singleElectronic->getName() . "\n";
        echo "  Prix: " . number_format($singleElectronic->getPrice() / 100, 2, ',', ' ') . " €\n";
        echo "  Marque: " . $singleElectronic->getBrand() . "\n";
        echo "  Frais de garantie: " . number_format($singleElectronic->getWarrantyFee() / 100, 2, ',', ' ') . " €\n";
    }
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 5 : Création et récupération
echo "Test 5 : Création d'un nouveau vêtement et vérification\n";
echo str_repeat("-", 70) . "\n\n";

$newJacket = new Clothing();
$newJacket->setName("Veste imperméable");
$newJacket->setPhotos(["jacket-imp1.jpg", "jacket-imp2.jpg"]);
$newJacket->setPrice(8900); // 89.00 €
$newJacket->setDescription("Veste imperméable pour toutes saisons");
$newJacket->setQuantity(45);
$newJacket->setCategoryId(2);
$newJacket->setSize("L");
$newJacket->setColor("Vert Olive");
$newJacket->setType("Veste");
$newJacket->setMaterialFee(1200);

echo "Création du vêtement : " . $newJacket->getName() . "\n";
$createResult = $newJacket->create();

if ($createResult !== false) {
    echo "✓ Vêtement créé! ID: " . $newJacket->getId() . "\n\n";

    // Vérification avec findAll
    $updatedList = $clothingInstance->findAll();
    echo "Nombre total de vêtements après création : " . count($updatedList) . "\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 6 : Création d'un produit électronique
echo "Test 6 : Création d'un nouveau produit électronique\n";
echo str_repeat("-", 70) . "\n\n";

$newPhone = new Electronic();
$newPhone->setName("iPhone 15 Pro");
$newPhone->setPhotos(["iphone15-1.jpg", "iphone15-2.jpg"]);
$newPhone->setPrice(119900); // 1199.00 €
$newPhone->setDescription("iPhone 15 Pro avec puce A17 Pro");
$newPhone->setQuantity(30);
$newPhone->setCategoryId(1);
$newPhone->setBrand("Apple");
$newPhone->setWarrantyFee(20000); // 200.00 €

echo "Création du produit : " . $newPhone->getName() . "\n";
$createResult2 = $newPhone->create();

if ($createResult2 !== false) {
    echo "✓ Produit électronique créé! ID: " . $newPhone->getId() . "\n\n";

    // Vérification avec findAll
    $updatedElectronics = $electronicInstance->findAll();
    echo "Nombre total de produits électroniques après création : " . count($updatedElectronics) . "\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "✓ Tous les tests sont terminés!\n";
echo str_repeat("=", 70) . "\n";
