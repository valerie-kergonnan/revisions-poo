<?php

require_once '../job-01/classe-product.php';
require_once '../job-02/classe-catagory.php';

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

    // Requête pour récupérer le produit avec l'id 7
    $sql = "SELECT * FROM product WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => 7]);

    // Récupération sous forme de tableau associatif
    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($productData) {
        echo "=== Données récupérées de la base de données ===\n";
        echo "ID: " . $productData['id'] . "\n";
        echo "Nom: " . $productData['name'] . "\n";
        echo "Prix: " . $productData['price'] . " centimes\n";
        echo "Description: " . $productData['description'] . "\n";
        echo "Quantité: " . $productData['quantity'] . "\n";
        echo "Category ID: " . $productData['category_id'] . "\n";
        echo "Photos (JSON): " . $productData['photos'] . "\n\n";

        // Création d'une nouvelle instance de Product
        $product = new Product();

        // Hydratation de l'instance avec les données de la base
        $product->setId((int)$productData['id']);
        $product->setName($productData['name']);
        $product->setPhotos(json_decode($productData['photos'], true)); // Conversion JSON vers array
        $product->setPrice((int)$productData['price']);
        $product->setDescription($productData['description']);
        $product->setQuantity((int)$productData['quantity']);
        $product->setCategoryId((int)$productData['category_id']);
        $product->setCreatedAt(new DateTime($productData['createdAt']));
        $product->setUpdatedAt(new DateTime($productData['updatedAt']));

        echo "=== Instance Product hydratée ===\n";
        echo "ID: " . $product->getId() . "\n";
        echo "Nom: " . $product->getName() . "\n";
        echo "Prix: " . $product->getPrice() . " centimes (" . number_format($product->getPrice() / 100, 2, ',', ' ') . " €)\n";
        echo "Description: " . $product->getDescription() . "\n";
        echo "Quantité: " . $product->getQuantity() . "\n";
        echo "Category ID: " . $product->getCategoryId() . "\n";
        echo "Photos: " . implode(', ', $product->getPhotos()) . "\n";
        echo "Créé le: " . $product->getCreatedAt()->format('d/m/Y H:i:s') . "\n";
        echo "Mis à jour le: " . $product->getUpdatedAt()->format('d/m/Y H:i:s') . "\n\n";

        echo "✓ Instance créée et hydratée avec succès!\n\n";

        // Récupération de la catégorie associée au produit via getCategory()
        echo str_repeat("=", 60) . "\n";
        echo "=== Job 05 : Récupération de la catégorie associée ===\n";
        echo str_repeat("=", 60) . "\n\n";

        $category = $product->getCategory();

        if ($category) {
            echo "✓ Catégorie récupérée avec succès via getCategory()!\n\n";
            echo "Informations de la catégorie :\n";
            echo "  ID: " . $category->getId() . "\n";
            echo "  Nom: " . $category->getName() . "\n";
            echo "  Description: " . $category->getDescription() . "\n";
            echo "  Créée le: " . $category->getCreatedAt()->format('d/m/Y H:i:s') . "\n";
            echo "  Mise à jour le: " . $category->getUpdatedAt()->format('d/m/Y H:i:s') . "\n\n";

            echo "🎉 Le produit '" . $product->getName() . "' appartient à la catégorie '" . $category->getName() . "'\n";
        } else {
            echo "⚠ Impossible de récupérer la catégorie associée\n";
        }
    } else {
        echo "⚠ Aucun produit trouvé avec l'ID 7\n";
        echo "Vérifiez que la base de données contient bien des produits.\n";
    }
} catch (PDOException $e) {
    echo "✗ Erreur de connexion ou de requête: " . $e->getMessage() . "\n";
    exit(1);
}
