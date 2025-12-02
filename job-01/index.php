<?php

require_once 'classe-product.php';


$product = new Product(
    1,
    'Ordinateur portable',
    ['photo1.jpg', 'photo2.jpg', 'photo3.jpg'],
    89999,
    'Un excellent ordinateur portable pour le travail et les loisirs',
    10
);

// Test des getters
echo "=== Test des getters ===\n";
var_dump($product->getId());
var_dump($product->getName());
var_dump($product->getPhotos());
var_dump($product->getPrice());
var_dump($product->getDescription());
var_dump($product->getQuantity());
var_dump($product->getCreatedAt());
var_dump($product->getUpdatedAt());

// Test des setters
echo "\n=== Test des setters ===\n";
$product->setName('Ordinateur portable premium');
$product->setPrice(109999);
$product->setQuantity(5);
$product->setUpdatedAt(new DateTime());

echo "\n=== Vérification après modification ===\n";
var_dump($product->getName());
var_dump($product->getPrice());
var_dump($product->getQuantity());
