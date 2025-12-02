<?php

/**
 * Interface StockableInterface
 * Définit les méthodes nécessaires pour gérer les stocks d'un produit
 */
interface StockableInterface
{
    /**
     * Ajoute du stock à un produit
     * @param int $stock La quantité à ajouter
     * @return self L'instance courante pour permettre le chaînage
     */
    public function addStocks(int $stock): self;

    /**
     * Retire du stock d'un produit
     * @param int $stock La quantité à retirer
     * @return self L'instance courante pour permettre le chaînage
     */
    public function removeStocks(int $stock): self;
}
