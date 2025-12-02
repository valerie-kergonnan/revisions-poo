<?php

/**
 * Script de création et d'initialisation de la base de données draft-shop
 */

// Configuration de la connexion (ajustez selon votre configuration Laragon)
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connexion sans sélection de base de données
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✓ Connexion au serveur MySQL réussie\n\n";

    // Lecture du fichier SQL
    $sqlFile = __DIR__ . '/database.sql';
    if (!file_exists($sqlFile)) {
        throw new Exception("Le fichier database.sql n'existe pas");
    }

    $sql = file_get_contents($sqlFile);

    // Séparation des requêtes
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function ($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );

    echo "Exécution des requêtes SQL...\n\n";

    // Exécution de chaque requête
    foreach ($statements as $statement) {
        if (empty(trim($statement))) continue;

        try {
            $pdo->exec($statement);

            // Afficher un message pour les opérations importantes
            if (stripos($statement, 'CREATE DATABASE') !== false) {
                echo "✓ Base de données 'draft-shop' créée\n";
            } elseif (stripos($statement, 'CREATE TABLE') !== false) {
                preg_match('/CREATE TABLE.*?`(\w+)`/i', $statement, $matches);
                if (isset($matches[1])) {
                    echo "✓ Table '{$matches[1]}' créée\n";
                }
            } elseif (stripos($statement, 'INSERT INTO') !== false) {
                preg_match('/INSERT INTO\s+`?(\w+)`?/i', $statement, $matches);
                if (isset($matches[1])) {
                    $tableName = $matches[1];
                    // Compter les insertions
                    $valueCount = substr_count($statement, '),(') + 1;
                    echo "✓ {$valueCount} enregistrement(s) inséré(s) dans '{$tableName}'\n";
                }
            }
        } catch (PDOException $e) {
            // Ignorer l'erreur si la base existe déjà
            if (strpos($e->getMessage(), 'database exists') === false) {
                echo "⚠ Avertissement: " . $e->getMessage() . "\n";
            }
        }
    }

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "✓ Base de données initialisée avec succès!\n";
    echo str_repeat("=", 50) . "\n\n";

    // Vérification des données
    $pdo->exec("USE `draft-shop`");

    $categoryCount = $pdo->query("SELECT COUNT(*) FROM category")->fetchColumn();
    $productCount = $pdo->query("SELECT COUNT(*) FROM product")->fetchColumn();

    echo "Statistiques:\n";
    echo "  - Catégories: {$categoryCount}\n";
    echo "  - Produits: {$productCount}\n\n";

    echo "Vous pouvez maintenant accéder à phpMyAdmin pour voir la base de données:\n";
    echo "http://localhost/phpmyadmin\n\n";
} catch (PDOException $e) {
    echo "✗ Erreur de connexion: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
    exit(1);
}
