<?php

class Product
{
    private ?int $id = null;
    private ?string $name = null;
    private ?array $photos = null;
    private ?int $price = null;
    private ?string $description = null;
    private ?int $quantity = null;
    private ?int $category_id = null;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?array $photos = null,
        ?int $price = null,
        ?string $description = null,
        ?int $quantity = null,
        ?int $category_id = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPhotos(): ?array
    {
        return $this->photos;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPhotos(array $photos): void
    {
        $this->photos = $photos;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    
    public function getCategory(): ?Category
    {
        if ($this->category_id === null) {
            return null;
        }

        try {
            // Configuration de la connexion à la base de données
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer la catégorie
            $sql = "SELECT * FROM category WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $this->category_id]);

            $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($categoryData) {
                // Création et hydratation de l'instance Category
                require_once __DIR__ . '/../job-02/classe-catagory.php';

                $category = new Category();
                $category->setId((int)$categoryData['id']);
                $category->setName($categoryData['name']);
                $category->setDescription($categoryData['description']);
                $category->setCreatedAt(new DateTime($categoryData['createdAt']));
                $category->setUpdatedAt(new DateTime($categoryData['updatedAt']));

                return $category;
            }

            return null;
        } catch (PDOException $e) {
            // En cas d'erreur, retourner null
            return null;
        }
    }

    /**
     * Recherche un produit par son ID et hydrate l'instance courante avec ses données
     * @param int $id L'ID du produit à rechercher
     * @return Product|false L'instance courante hydratée si trouvée, false sinon
     */
    public function findOneById(int $id): Product|false
    {
        try {
            // Configuration de la connexion à la base de données
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer le produit
            $sql = "SELECT * FROM product WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);

            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($productData) {
                // Hydratation de l'instance courante avec les données
                $this->setId((int)$productData['id']);
                $this->setName($productData['name']);
                $this->setPhotos(json_decode($productData['photos'], true));
                $this->setPrice((int)$productData['price']);
                $this->setDescription($productData['description']);
                $this->setQuantity((int)$productData['quantity']);
                $this->setCategoryId((int)$productData['category_id']);
                $this->setCreatedAt(new DateTime($productData['createdAt']));
                $this->setUpdatedAt(new DateTime($productData['updatedAt']));

                return $this;
            }

            return false;
        } catch (PDOException $e) {
            // En cas d'erreur, retourner false
            return false;
        }
    }
}
