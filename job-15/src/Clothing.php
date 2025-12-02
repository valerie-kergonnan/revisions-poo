<?php

namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use DateTime;
use PDO;
use PDOException;

/**
 * Classe Clothing - Représente un vêtement
 * Hérite de AbstractProduct et implémente StockableInterface
 */
class Clothing extends AbstractProduct implements StockableInterface
{
    private ?string $size = null;
    private ?string $color = null;
    private ?string $type = null;
    private ?int $material_fee = null;

    // Getters
    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getMaterialFee(): ?int
    {
        return $this->material_fee;
    }

    // Setters
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setMaterialFee(int $material_fee): void
    {
        $this->material_fee = $material_fee;
    }

    /**
     * Ajoute du stock au vêtement
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
     * Retire du stock du vêtement
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
     * Recherche un vêtement par son ID et hydrate l'instance
     * @param int $id L'ID du produit/vêtement à rechercher
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

            // Récupération jointe des données product et clothing
            $sql = "SELECT p.*, c.size, c.color, c.type, c.material_fee 
                    FROM product p 
                    INNER JOIN clothing c ON p.id = c.product_id 
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

                // Hydratation des propriétés Clothing
                $this->size = $data['size'];
                $this->color = $data['color'];
                $this->type = $data['type'];
                $this->material_fee = (int)$data['material_fee'];

                return $this;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Récupère tous les vêtements de la base de données
     * @return Clothing[] Tableau d'instances Clothing
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

            // Requête jointe pour récupérer produits et vêtements
            $sql = "SELECT p.*, c.size, c.color, c.type, c.material_fee 
                    FROM product p 
                    INNER JOIN clothing c ON p.id = c.product_id";

            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $clothings = [];

            foreach ($data as $row) {
                $clothing = new Clothing();

                // Hydratation des propriétés Product
                $clothing->setId((int)$row['id']);
                $clothing->setName($row['name']);
                $clothing->setPhotos(json_decode($row['photos'], true));
                $clothing->setPrice((int)$row['price']);
                $clothing->setDescription($row['description']);
                $clothing->setQuantity((int)$row['quantity']);
                $clothing->setCategoryId((int)$row['category_id']);
                $clothing->setCreatedAt(new DateTime($row['createdAt']));
                $clothing->setUpdatedAt(new DateTime($row['updatedAt']));

                // Hydratation des propriétés Clothing
                $clothing->setSize($row['size']);
                $clothing->setColor($row['color']);
                $clothing->setType($row['type']);
                $clothing->setMaterialFee((int)$row['material_fee']);

                $clothings[] = $clothing;
            }

            return $clothings;
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Crée un vêtement en insérant d'abord dans product puis dans clothing
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

            // Insertion dans la table clothing
            $sql = "INSERT INTO clothing (product_id, size, color, type, material_fee) 
                    VALUES (:product_id, :size, :color, :type, :material_fee)";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'product_id' => $this->getId(),
                'size' => $this->size,
                'color' => $this->color,
                'type' => $this->type,
                'material_fee' => $this->material_fee
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
     * Met à jour un vêtement dans les tables product et clothing
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

            // Mise à jour dans la table clothing
            $sql = "UPDATE clothing 
                    SET size = :size, 
                        color = :color, 
                        type = :type, 
                        material_fee = :material_fee 
                    WHERE product_id = :product_id";

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                'product_id' => $this->getId(),
                'size' => $this->size,
                'color' => $this->color,
                'type' => $this->type,
                'material_fee' => $this->material_fee
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
