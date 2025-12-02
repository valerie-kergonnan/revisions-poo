<?php

class Category
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $description = null;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $description = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Récupère tous les produits associés à cette catégorie depuis la base de données
     * @return Product[] Tableau d'instances Product (vide si aucun produit)
     */
    public function getProducts(): array
    {
        if ($this->id === null) {
            return [];
        }

        try {
            // Configuration de la connexion à la base de données
            $host = 'localhost';
            $dbname = 'draft-shop';
            $username = 'root';
            $password = '';

            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer tous les produits de cette catégorie
            $sql = "SELECT * FROM product WHERE category_id = :category_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['category_id' => $this->id]);

            $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $products = [];

            // Création et hydratation des instances Product
            require_once __DIR__ . '/../job-01/classe-product.php';

            foreach ($productsData as $productData) {
                $product = new Product();
                $product->setId((int)$productData['id']);
                $product->setName($productData['name']);
                $product->setPhotos(json_decode($productData['photos'], true));
                $product->setPrice((int)$productData['price']);
                $product->setDescription($productData['description']);
                $product->setQuantity((int)$productData['quantity']);
                $product->setCategoryId((int)$productData['category_id']);
                $product->setCreatedAt(new DateTime($productData['createdAt']));
                $product->setUpdatedAt(new DateTime($productData['updatedAt']));

                $products[] = $product;
            }

            return $products;
        } catch (PDOException $e) {
            // En cas d'erreur, retourner un tableau vide
            return [];
        }
    }
}
