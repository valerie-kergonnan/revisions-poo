<?php

namespace App\Abstract;

use DateTime;

abstract class AbstractProduct
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

    /**
     * Méthode abstraite : recherche un produit par son ID
     * Doit être implémentée dans les classes enfants
     * @param int $id L'ID du produit à rechercher
     * @return static|false L'instance hydratée si trouvée, false sinon
     */
    abstract public function findOneById(int $id): static|false;

    /**
     * Méthode abstraite : récupère tous les produits
     * Doit être implémentée dans les classes enfants
     * @return array Tableau d'instances du type de produit
     */
    abstract public function findAll(): array;

    /**
     * Méthode abstraite : crée un nouveau produit
     * Doit être implémentée dans les classes enfants
     * @return static|false L'instance avec l'ID généré si succès, false sinon
     */
    abstract public function create(): static|false;

    /**
     * Méthode abstraite : met à jour un produit existant
     * Doit être implémentée dans les classes enfants
     * @return static|false L'instance mise à jour si succès, false sinon
     */
    abstract public function update(): static|false;
}
