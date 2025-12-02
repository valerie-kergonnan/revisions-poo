<?php

// Chargement de l'autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Utilisation des classes avec leur namespace complet
use App\Clothing;
use App\Electronic;

echo str_repeat("=", 70) . PHP_EOL;
echo "=== Job 15 : Autoloading avec Composer et Namespaces ===" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo PHP_EOL;

// Test 1 : Vérifier que l'autoloading fonctionne avec Clothing
echo "Test 1 : Chargement automatique de la classe Clothing" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

try {
    $clothing = new Clothing();
    echo "✓ Classe Clothing chargée automatiquement via Composer!" . PHP_EOL;
    echo "  Namespace: App\\Clothing" . PHP_EOL;
    echo "  Fichier: src/Clothing.php" . PHP_EOL;
} catch (Error $e) {
    echo "❌ Erreur lors du chargement de Clothing: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 2 : Vérifier que l'autoloading fonctionne avec Electronic
echo "Test 2 : Chargement automatique de la classe Electronic" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

try {
    $electronic = new Electronic();
    echo "✓ Classe Electronic chargée automatiquement via Composer!" . PHP_EOL;
    echo "  Namespace: App\\Electronic" . PHP_EOL;
    echo "  Fichier: src/Electronic.php" . PHP_EOL;
} catch (Error $e) {
    echo "❌ Erreur lors du chargement de Electronic: " . $e->getMessage() . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 3 : Récupération d'un vêtement existant
echo "Test 3 : Utilisation de Clothing avec la base de données" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$clothing = (new Clothing())->findOneById(24);

if ($clothing !== false) {
    echo "✓ Vêtement trouvé:" . PHP_EOL;
    echo "  - ID: " . $clothing->getId() . PHP_EOL;
    echo "  - Nom: " . $clothing->getName() . PHP_EOL;
    echo "  - Taille: " . $clothing->getSize() . PHP_EOL;
    echo "  - Couleur: " . $clothing->getColor() . PHP_EOL;
    echo "  - Stock: " . $clothing->getQuantity() . PHP_EOL;
} else {
    echo "❌ Vêtement non trouvé." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 4 : Utilisation de l'interface StockableInterface
echo "Test 4 : Gestion du stock via StockableInterface" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$electronic = (new Electronic())->findOneById(25);

if ($electronic !== false) {
    $stockInitial = $electronic->getQuantity();
    echo "Produit: " . $electronic->getName() . PHP_EOL;
    echo "Stock initial: " . $stockInitial . PHP_EOL;

    // Utilisation des méthodes de l'interface
    $electronic->addStocks(15)
        ->removeStocks(5);

    echo "Après ajout de 15 et retrait de 5: " . $electronic->getQuantity() . PHP_EOL;

    if ($electronic->update()) {
        echo "✓ Stock mis à jour en base de données!" . PHP_EOL;
    }
} else {
    echo "❌ Produit électronique non trouvé." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 5 : Création d'un nouveau produit
echo "Test 5 : Création d'un nouveau vêtement" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

$newClothing = new Clothing();
$newClothing->setName("Pull en laine");
$newClothing->setPhotos(["pull1.jpg", "pull2.jpg"]);
$newClothing->setPrice(4990); // 49,90€
$newClothing->setDescription("Pull chaud pour l'hiver");
$newClothing->setQuantity(25);
$newClothing->setCategoryId(1);
$newClothing->setSize("M");
$newClothing->setColor("Bleu marine");
$newClothing->setType("Pull");
$newClothing->setMaterialFee(700);

$result = $newClothing->create();

if ($result !== false) {
    echo "✓ Nouveau vêtement créé avec ID: " . $result->getId() . PHP_EOL;
    echo "  - Nom: " . $result->getName() . PHP_EOL;
    echo "  - Prix: " . number_format($result->getPrice() / 100, 2, ',', ' ') . " €" . PHP_EOL;
} else {
    echo "❌ Erreur lors de la création." . PHP_EOL;
}

echo PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;
echo PHP_EOL;

// Test 6 : Vérification de la structure des namespaces
echo "Test 6 : Vérification de la structure des namespaces" . PHP_EOL;
echo str_repeat("-", 70) . PHP_EOL;

echo "Structure du projet:" . PHP_EOL;
echo "  job-15/" . PHP_EOL;
echo "  ├── composer.json (autoload PSR-4: App\\ => src/)" . PHP_EOL;
echo "  ├── vendor/" . PHP_EOL;
echo "  │   └── autoload.php ✓" . PHP_EOL;
echo "  ├── src/" . PHP_EOL;
echo "  │   ├── Abstract/" . PHP_EOL;
echo "  │   │   └── AbstractProduct.php (App\\Abstract\\AbstractProduct)" . PHP_EOL;
echo "  │   ├── Interface/" . PHP_EOL;
echo "  │   │   └── StockableInterface.php (App\\Interface\\StockableInterface)" . PHP_EOL;
echo "  │   ├── Clothing.php (App\\Clothing)" . PHP_EOL;
echo "  │   └── Electronic.php (App\\Electronic)" . PHP_EOL;
echo "  └── index.php (require vendor/autoload.php uniquement!)" . PHP_EOL;

echo PHP_EOL;
echo "✓ Plus besoin de require/require_once pour chaque classe!" . PHP_EOL;
echo "✓ Composer gère automatiquement le chargement des classes." . PHP_EOL;

echo PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
echo "✓ Tous les tests avec Composer autoloader sont terminés!" . PHP_EOL;
echo str_repeat("=", 70) . PHP_EOL;
