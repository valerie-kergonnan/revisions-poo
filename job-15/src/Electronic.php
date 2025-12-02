<?php

namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use DateTime;
use PDO;
use PDOException;

/**
 * Classe Electronic - Représente un produit électronique
 * Hérite de AbstractProduct et implémente StockableInterface
 */
class Electronic extends AbstractProduct implements StockableInterface
{
    private ?string $brand = null;
    private ?int $warranty_fee = null;

    // Getters
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getWarrantyFee(): ?int
    {
        return $this->warranty_fee;
    }

    // Setters
    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setWarrantyFee(int $warranty_fee): void
    {
        $this->warranty_fee = $warranty_fee;
    }

    /**
     * Ajoute du stock au produit électronique
     * @param int $stock La quantité à ajouter
     * @return self L'instance courante pour permettre le chaînage
     */
    public function addStocks(int $stock): self
    {
        $currentQuantity = $this->getQuantity() ?? 0;
        $this->setQuantity($currentQuantity + $stock);
        return $this;
    }

    /**
     * Retire du stock du produit électronique
     * @param int $stock La quantité à retirer
     * @return self L'instance courante pour permettre le chaînage
     */
    public function removeStocks(int $stock): self
    {
        $currentQuantity = $this->getQuantity() ?? 0;
        $newQuantity = max(0, $currentQuantity - $stock);
        $this->setQuantity($newQuantity);
        return $this;
    }

    /**
     * Recherche un produit électronique par son ID et hydrate l'instance
     * @param int $id L'ID du produit/électronique à rechercher
     * @return static|false L'instance hydratée si trouvée, false sinon
     */
    public function findOneById(int $id): static|false
    {
        try {
            // Configuration de la connexion
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Récupération jointe des données product et electronic
            $sql = "SELECT p.*, e.brand, e.warranty_fee 
                    FROM product p 
                    INNER JOIN electronic e ON p.id = e.product_id 
                    WHERE p.id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                // Hydratation des propriétés Product
                $this->setId((int)$data['id']);
                $this->setName($data['name']);
                $this->setPhotos(json_decode($data['photos'], true));
                $this->setPrice((int)$data['price']);
                $this->setDescription($data['description']);
                $this->setQuantity((int)$data['quantity']);
                $this->setCategoryId((int)$data['category_id']);
                $this->setCreatedAt(new DateTime($data['createdAt']));
                $this->setUpdatedAt(new DateTime($data['updatedAt']));

                // Hydratation des propriétés Electronic
                $this->brand = $data['brand'];
                $this->warranty_fee = (int)$data['warranty_fee'];

                return $this;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Récupère tous les produits électroniques de la base de données
     * @return Electronic[] Tableau d'instances Electronic
     */
    public function findAll(): array
    {
        try {
            // Configuration de la connexion
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête jointe pour récupérer produits et électronique
            $sql = "SELECT p.*, e.brand, e.warranty_fee 
                    FROM product p 
                    INNER JOIN electronic e ON p.id = e.product_id";

            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $electronics = [];

            foreach ($data as $row) {
                $electronic = new Electronic();

                // Hydratation des propriétés Product
                $electronic->setId((int)$row['id']);
                $electronic->setName($row['name']);
                $electronic->setPhotos(json_decode($row['photos'], true));
                $electronic->setPrice((int)$row['price']);
                $electronic->setDescription($row['description']);
                $electronic->setQuantity((int)$row['quantity']);
                $electronic->setCategoryId((int)$row['category_id']);
                $electronic->setCreatedAt(new DateTime($row['createdAt']));
                $electronic->setUpdatedAt(new DateTime($row['updatedAt']));

                // Hydratation des propriétés Electronic
                $electronic->setBrand($row['brand']);
                $electronic->setWarrantyFee((int)$row['warranty_fee']);

                $electronics[] = $electronic;
            }

            return $electronics;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Crée un produit électronique en insérant d'abord dans product puis dans electronic
     * @return static|false L'instance avec l'ID généré si succès, false sinon
     */
    public function create(): static|false
    {
        try {
            // Configuration de la connexion
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insertion dans la table product
            $sql = "INSERT INTO product (name, photos, price, description, quantity, category_id, createdAt, updatedAt) 
                    VALUES (:name, :photos, :price, :description, :quantity, :category_id, :createdAt, :updatedAt)";

            $stmt = $pdo->prepare($sql);

            $photosJson = json_encode($this->getPhotos());

            $result = $stmt->execute([
                'name' => $this->getName(),
                'photos' => $photosJson,
                'price' => $this->getPrice(),
                'description' => $this->getDescription(),
                'quantity' => $this->getQuantity(),
                'category_id' => $this->getCategoryId(),
                'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            if (!$result) {
                return false;
            }

            // Récupération de l'ID généré
            $this->setId((int)$pdo->lastInsertId());

            // Insertion dans la table electronic
            $sql = "INSERT INTO electronic (product_id, brand, warranty_fee) 
                    VALUES (:product_id, :brand, :warranty_fee)";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'product_id' => $this->getId(),
                'brand' => $this->brand,
                'warranty_fee' => $this->warranty_fee
            ]);

            if ($result) {
                return $this;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Met à jour un produit électronique dans les tables product et electronic
     * @return static|false L'instance mise à jour si succès, false sinon
     */
    public function update(): static|false
    {
        // Vérifier que l'ID existe
        if ($this->getId() === null) {
            return false;
        }

        try {
            // Configuration de la connexion
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Mise à jour de la date
            $this->setUpdatedAt(new DateTime());

            // Mise à jour dans la table product
            $sql = "UPDATE product 
                    SET name = :name, 
                        photos = :photos, 
                        price = :price, 
                        description = :description, 
                        quantity = :quantity, 
                        category_id = :category_id, 
                        updatedAt = :updatedAt 
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $photosJson = json_encode($this->getPhotos());

            $result = $stmt->execute([
                'id' => $this->getId(),
                'name' => $this->getName(),
                'photos' => $photosJson,
                'price' => $this->getPrice(),
                'description' => $this->getDescription(),
                'quantity' => $this->getQuantity(),
                'category_id' => $this->getCategoryId(),
                'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
            ]);

            if (!$result) {
                return false;
            }

            // Mise à jour dans la table electronic
            $sql = "UPDATE electronic 
                    SET brand = :brand, 
                        warranty_fee = :warranty_fee 
                    WHERE product_id = :product_id";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'product_id' => $this->getId(),
                'brand' => $this->brand,
                'warranty_fee' => $this->warranty_fee
            ]);

            if ($result) {
                return $this;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
