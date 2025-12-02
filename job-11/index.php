<?php

require_once 'classe-clothing.php';
require_once 'classe-electronic.php';

echo str_repeat("=", 70) . "\n";
echo "=== Job 11 : Classes Clothing et Electronic (Héritage) ===\n";
echo str_repeat("=", 70) . "\n\n";

// Test 1 : Création d'un vêtement (Clothing)
echo "Test 1 : Création d'un vêtement\n";
echo str_repeat("-", 70) . "\n\n";

$tshirt = new Clothing();
$tshirt->setName("T-shirt Bio Premium");
$tshirt->setPhotos(["tshirt-bio1.jpg", "tshirt-bio2.jpg"]);
$tshirt->setPrice(3500); // 35.00 €
$tshirt->setDescription("T-shirt en coton bio certifié, coupe moderne");
$tshirt->setQuantity(80);
$tshirt->setCategoryId(2); // Vêtements

// Propriétés spécifiques au vêtement
$tshirt->setSize("M");
$tshirt->setColor("Bleu Marine");
$tshirt->setType("T-shirt");
$tshirt->setMaterialFee(500); // 5.00 € de frais de matière

echo "Création du vêtement : " . $tshirt->getName() . "\n";
echo "  Taille: " . $tshirt->getSize() . "\n";
echo "  Couleur: " . $tshirt->getColor() . "\n";
echo "  Type: " . $tshirt->getType() . "\n";
echo "  Frais de matière: " . number_format($tshirt->getMaterialFee() / 100, 2, ',', ' ') . " €\n\n";

$result = $tshirt->create();

if ($result !== false) {
    echo "✓ Vêtement créé avec succès! ID: " . $tshirt->getId() . "\n";
} else {
    echo "✗ Échec de la création du vêtement\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 2 : Création d'un produit électronique (Electronic)
echo "Test 2 : Création d'un produit électronique\n";
echo str_repeat("-", 70) . "\n\n";

$laptop = new Electronic();
$laptop->setName("Dell XPS 15");
$laptop->setPhotos(["dell-xps1.jpg", "dell-xps2.jpg", "dell-xps3.jpg"]);
$laptop->setPrice(179900); // 1799.00 €
$laptop->setDescription("Laptop professionnel Dell XPS 15, Intel i7, 16Go RAM, 1To SSD");
$laptop->setQuantity(12);
$laptop->setCategoryId(1); // Électronique

// Propriétés spécifiques au produit électronique
$laptop->setBrand("Dell");
$laptop->setWarrantyFee(15000); // 150.00 € de frais de garantie

echo "Création du produit électronique : " . $laptop->getName() . "\n";
echo "  Marque: " . $laptop->getBrand() . "\n";
echo "  Frais de garantie: " . number_format($laptop->getWarrantyFee() / 100, 2, ',', ' ') . " €\n\n";

$result2 = $laptop->create();

if ($result2 !== false) {
    echo "✓ Produit électronique créé avec succès! ID: " . $laptop->getId() . "\n";
} else {
    echo "✗ Échec de la création du produit électronique\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 3 : Récupération et affichage d'un vêtement
echo "Test 3 : Récupération d'un vêtement depuis la base\n";
echo str_repeat("-", 70) . "\n\n";

$clothingCheck = new Clothing();
$clothingResult = $clothingCheck->findOneById($tshirt->getId());

if ($clothingResult !== false) {
    echo "✓ Vêtement récupéré:\n";
    echo "  ID: " . $clothingCheck->getId() . "\n";
    echo "  Nom: " . $clothingCheck->getName() . "\n";
    echo "  Prix: " . number_format($clothingCheck->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Taille: " . $clothingCheck->getSize() . "\n";
    echo "  Couleur: " . $clothingCheck->getColor() . "\n";
    echo "  Type: " . $clothingCheck->getType() . "\n";
    echo "  Frais de matière: " . number_format($clothingCheck->getMaterialFee() / 100, 2, ',', ' ') . " €\n";
} else {
    echo "✗ Échec de la récupération\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 4 : Récupération et affichage d'un produit électronique
echo "Test 4 : Récupération d'un produit électronique depuis la base\n";
echo str_repeat("-", 70) . "\n\n";

$electronicCheck = new Electronic();
$electronicResult = $electronicCheck->findOneById($laptop->getId());

if ($electronicResult !== false) {
    echo "✓ Produit électronique récupéré:\n";
    echo "  ID: " . $electronicCheck->getId() . "\n";
    echo "  Nom: " . $electronicCheck->getName() . "\n";
    echo "  Prix: " . number_format($electronicCheck->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Marque: " . $electronicCheck->getBrand() . "\n";
    echo "  Frais de garantie: " . number_format($electronicCheck->getWarrantyFee() / 100, 2, ',', ' ') . " €\n";
} else {
    echo "✗ Échec de la récupération\n";
}

echo "\n" . str_repeat("-", 70) . "\n\n";

// Test 5 : Mise à jour d'un vêtement
echo "Test 5 : Mise à jour d'un vêtement\n";
echo str_repeat("-", 70) . "\n\n";

$clothingCheck->setPrice(2990); // Nouvelle promo: 29.90 €
$clothingCheck->setQuantity(100);
$clothingCheck->setSize("L");
$clothingCheck->setColor("Noir");

echo "Modification : prix, quantité, taille et couleur\n";
$updateResult = $clothingCheck->update();

if ($updateResult !== false) {
    echo "✓ Vêtement mis à jour avec succès!\n";
    echo "  Nouveau prix: " . number_format($clothingCheck->getPrice() / 100, 2, ',', ' ') . " €\n";
    echo "  Nouvelle quantité: " . $clothingCheck->getQuantity() . "\n";
    echo "  Nouvelle taille: " . $clothingCheck->getSize() . "\n";
    echo "  Nouvelle couleur: " . $clothingCheck->getColor() . "\n";
} else {
    echo "✗ Échec de la mise à jour\n";
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "✓ Tous les tests sont terminés!\n";
echo str_repeat("=", 70) . "\n";
