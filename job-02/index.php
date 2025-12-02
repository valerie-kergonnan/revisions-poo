<?php

require_once 'classe-catagory.php';
require_once '../job-01/classe-product.php';

// Création de catégories
$category1 = new Category(
    1,
    "Électronique",
    "Produits électroniques et high-tech"
);

$category2 = new Category(
    2,
    "Vêtements",
    "Mode et accessoires pour tous"
);

$category3 = new Category(
    3,
    "Livres",
    "Romans, BD, magazines et plus"
);

// Création de produits avec category_id
$product1 = new Product(
    1,
    "Smartphone XYZ",
    ["smartphone1.jpg", "smartphone2.jpg"],
    599,
    "Smartphone dernier cri avec écran OLED",
    50,
    1 // category_id: Électronique
);

$product2 = new Product(
    2,
    "T-shirt Premium",
    ["tshirt1.jpg", "tshirt2.jpg"],
    29,
    "T-shirt 100% coton bio",
    120,
    2 // category_id: Vêtements
);

$product3 = new Product(
    3,
    "Le Seigneur des Anneaux",
    ["livre1.jpg"],
    25,
    "Trilogie complète de J.R.R. Tolkien",
    30,
    3 // category_id: Livres
);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job-02 - Catégories et Produits</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        h2 {
            color: #555;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #4CAF50;
        }

        .categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .category-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .category-card h3 {
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .category-card .info {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .product-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .product-card h3 {
            color: #2196F3;
            margin-bottom: 10px;
        }

        .product-card .price {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            margin: 10px 0;
        }

        .product-card .info {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-top: 15px;
        }

        .label {
            font-weight: bold;
            color: #666;
        }

        .value {
            color: #333;
        }

        .photos {
            color: #2196F3;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #e3f2fd;
            color: #1976d2;
            border-radius: 12px;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🏪 Gestion des Catégories et Produits</h1>

        <section>
            <h2>📁 Catégories</h2>
            <div class="categories">
                <?php
                $categories = [$category1, $category2, $category3];
                foreach ($categories as $category) {
                    echo '<div class="category-card">';
                    echo '<h3>' . htmlspecialchars($category->getName()) . '</h3>';
                    echo '<p>' . htmlspecialchars($category->getDescription()) . '</p>';
                    echo '<div class="info">';
                    echo '<div><span class="label">ID:</span> <span class="value">' . $category->getId() . '</span></div>';
                    echo '<div><span class="label">Créée le:</span> <span class="value">' . $category->getCreatedAt()->format('d/m/Y H:i:s') . '</span></div>';
                    echo '<div><span class="label">Modifiée le:</span> <span class="value">' . $category->getUpdatedAt()->format('d/m/Y H:i:s') . '</span></div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>

        <section>
            <h2>🛍️ Produits</h2>
            <div class="products">
                <?php
                $products = [$product1, $product2, $product3];
                foreach ($products as $product) {
                    echo '<div class="product-card">';
                    echo '<h3>' . htmlspecialchars($product->getName()) . '</h3>';
                    echo '<p>' . htmlspecialchars($product->getDescription()) . '</p>';
                    echo '<div class="price">' . number_format($product->getPrice(), 2, ',', ' ') . ' €</div>';
                    echo '<div class="info">';
                    echo '<div><span class="label">ID:</span> <span class="value">' . $product->getId() . '</span></div>';
                    echo '<div><span class="label">Quantité en stock:</span> <span class="value">' . $product->getQuantity() . '</span></div>';
                    echo '<div><span class="label">Catégorie ID:</span> <span class="value">' . $product->getCategoryId() . '</span></div>';
                    echo '<div><span class="label">Photos:</span> <span class="photos">' . implode(', ', $product->getPhotos()) . '</span></div>';
                    echo '<div><span class="label">Créé le:</span> <span class="value">' . $product->getCreatedAt()->format('d/m/Y H:i:s') . '</span></div>';
                    echo '<div><span class="label">Modifié le:</span> <span class="value">' . $product->getUpdatedAt()->format('d/m/Y H:i:s') . '</span></div>';
                    echo '</div>';

                    // Afficher le nom de la catégorie associée
                    $categoryName = '';
                    foreach ($categories as $cat) {
                        if ($cat->getId() === $product->getCategoryId()) {
                            $categoryName = $cat->getName();
                            break;
                        }
                    }
                    echo '<span class="badge">📁 ' . htmlspecialchars($categoryName) . '</span>';

                    echo '</div>';
                }
                ?>
            </div>
        </section>
    </div>
</body>

</html>