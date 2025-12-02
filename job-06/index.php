<?php

require_once '../job-02/classe-catagory.php';
require_once '../job-01/classe-product.php';

// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'draft-shop';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✓ Connexion à la base de données réussie\n\n";

    echo str_repeat("=", 70) . "\n";
    echo "=== Job 06 : Récupération des produits d'une catégorie ===\n";
    echo str_repeat("=", 70) . "\n\n";

    // Récupération de la catégorie "Électronique" (id = 1)
    $sql = "SELECT * FROM category WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => 1]);

    $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($categoryData) {
        // Création et hydratation de l'instance Category
        $category = new Category();
        $category->setId((int)$categoryData['id']);
        $category->setName($categoryData['name']);
        $category->setDescription($categoryData['description']);
        $category->setCreatedAt(new DateTime($categoryData['createdAt']));
        $category->setUpdatedAt(new DateTime($categoryData['updatedAt']));

        echo "Catégorie sélectionnée :\n";
        echo "  ID: " . $category->getId() . "\n";
        echo "  Nom: " . $category->getName() . "\n";
        echo "  Description: " . $category->getDescription() . "\n\n";

        // Récupération des produits via getProducts()
        echo "Récupération des produits de cette catégorie...\n\n";
        $products = $category->getProducts();

        if (count($products) > 0) {
            echo "✓ " . count($products) . " produit(s) trouvé(s) dans la catégorie '" . $category->getName() . "'\n\n";

            foreach ($products as $index => $product) {
                echo "--- Produit " . ($index + 1) . " ---\n";
                echo "  ID: " . $product->getId() . "\n";
                echo "  Nom: " . $product->getName() . "\n";
                echo "  Prix: " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
                echo "  Description: " . $product->getDescription() . "\n";
                echo "  Quantité en stock: " . $product->getQuantity() . "\n";
                echo "  Photos: " . implode(', ', $product->getPhotos()) . "\n";
                echo "\n";
            }

            echo "✓ Tous les produits ont été récupérés avec succès!\n\n";
        } else {
            echo "⚠ Aucun produit trouvé dans cette catégorie\n";
        }

        // Test avec une autre catégorie (Vêtements, id = 2)
        echo str_repeat("-", 70) . "\n\n";
        echo "Test avec une autre catégorie : Vêtements\n\n";

        $stmt->execute(['id' => 2]);
        $categoryData2 = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($categoryData2) {
            $category2 = new Category();
            $category2->setId((int)$categoryData2['id']);
            $category2->setName($categoryData2['name']);
            $category2->setDescription($categoryData2['description']);
            $category2->setCreatedAt(new DateTime($categoryData2['createdAt']));
            $category2->setUpdatedAt(new DateTime($categoryData2['updatedAt']));

            echo "Catégorie : " . $category2->getName() . "\n";
            $products2 = $category2->getProducts();
            echo "Nombre de produits : " . count($products2) . "\n\n";

            foreach ($products2 as $product) {
                echo "  • " . $product->getName() . " - " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €\n";
            }
        }
    } else {
        echo "⚠ Catégorie non trouvée\n";
    }
} catch (PDOException $e) {
    echo "✗ Erreur de connexion ou de requête: " . $e->getMessage() . "\n";
    exit(1);
}
