# Job 03 - Base de données draft-shop

## Description

Création de la base de données `draft-shop` avec les tables `category` et `product`.

## Structure de la base de données

### Table `category`
- `id` : INT, clé primaire, auto-incrémenté
- `name` : VARCHAR(255), nom de la catégorie
- `description` : TEXT, description de la catégorie
- `createdAt` : DATETIME, date de création
- `updatedAt` : DATETIME, date de mise à jour

### Table `product`
- `id` : INT, clé primaire, auto-incrémenté
- `name` : VARCHAR(255), nom du produit
- `photos` : TEXT, photos au format JSON
- `price` : INT, prix en centimes
- `description` : TEXT, description du produit
- `quantity` : INT, quantité en stock
- `category_id` : INT, clé étrangère vers category
- `createdAt` : DATETIME, date de création
- `updatedAt` : DATETIME, date de mise à jour

### Relation
- Une catégorie peut contenir plusieurs produits (1,n)
- Un produit appartient à une seule catégorie (1,1)
- Clé étrangère avec `ON DELETE RESTRICT ON UPDATE CASCADE`

## Installation

### Méthode 1 : Via le script PHP (Recommandé)

1. Assurez-vous que Laragon est démarré
2. Exécutez le script depuis le terminal PowerShell :
   ```powershell
   php create-database.php
   ```

### Méthode 2 : Via phpMyAdmin

1. Ouvrez phpMyAdmin : http://localhost/phpmyadmin
2. Cliquez sur l'onglet "SQL"
3. Copiez le contenu du fichier `database.sql`
4. Collez-le dans la zone de texte et cliquez sur "Exécuter"

## Données insérées

### Catégories (5)
1. Électronique
2. Vêtements
3. Livres
4. Maison & Jardin
5. Sports & Loisirs

### Produits (19)
- 4 produits électroniques
- 4 vêtements
- 4 livres
- 3 produits maison & jardin
- 4 produits sports & loisirs

## Vérification

Pour vérifier que tout est bien installé :

```sql
USE `draft-shop`;
SELECT * FROM category;
SELECT * FROM product;
```

Ou visitez phpMyAdmin : http://localhost/phpmyadmin
