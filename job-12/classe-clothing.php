<?php

require_once __DIR__ . '/classe-product.php';

/**
 * Classe Clothing - Représente un vêtement
 * Hérite de Product et ajoute des propriétés spécifiques aux vêtements
 */
class Clothing extends Product
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
     * Crée un vêtement en insérant d'abord dans product puis dans clothing
     * @return Clothing|false L'instance avec l'ID généré si succès, false sinon
     */
    public function create(): Clothing|false
    {
        // Appel de la méthode create() du parent pour insérer dans product
        $result = parent::create();

        if ($result === false) {
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
     * @return Clothing|false L'instance mise à jour si succès, false sinon
     */
    public function update(): Clothing|false
    {
        // Appel de la méthode update() du parent pour mettre à jour product
        $result = parent::update();

        if ($result === false) {
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

    /**
     * Recherche un vêtement par son ID et hydrate l'instance
     * @param int $id L'ID du produit/vêtement à rechercher
     * @return Clothing|false L'instance hydratée si trouvée, false sinon
     */
    public function findOneById(int $id): Clothing|false
    {
        // Appel de la méthode du parent pour charger les données product
        $result = parent::findOneById($id);

        if ($result === false) {
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

            // Récupération des données spécifiques à clothing
            $sql = "SELECT * FROM clothing WHERE product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['product_id' => $id]);

            $clothingData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($clothingData) {
                $this->size = $clothingData['size'];
                $this->color = $clothingData['color'];
                $this->type = $clothingData['type'];
                $this->material_fee = (int)$clothingData['material_fee'];

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
}
