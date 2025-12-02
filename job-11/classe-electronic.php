<?php

require_once __DIR__ . '/../job-01/classe-product.php';

/**
 * Classe Electronic - Représente un produit électronique
 * Hérite de Product et ajoute des propriétés spécifiques aux produits électroniques
 */
class Electronic extends Product
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
     * Crée un produit électronique en insérant d'abord dans product puis dans electronic
     * @return Electronic|false L'instance avec l'ID généré si succès, false sinon
     */
    public function create(): Electronic|false
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
     * @return Electronic|false L'instance mise à jour si succès, false sinon
     */
    public function update(): Electronic|false
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

    /**
     * Recherche un produit électronique par son ID et hydrate l'instance
     * @param int $id L'ID du produit/électronique à rechercher
     * @return Electronic|false L'instance hydratée si trouvée, false sinon
     */
    public function findOneById(int $id): Electronic|false
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

            // Récupération des données spécifiques à electronic
            $sql = "SELECT * FROM electronic WHERE product_id = :product_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['product_id' => $id]);

            $electronicData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($electronicData) {
                $this->brand = $electronicData['brand'];
                $this->warranty_fee = (int)$electronicData['warranty_fee'];

                return $this;
            }

            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
