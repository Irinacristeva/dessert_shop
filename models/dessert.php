<?php
// models/Dessert.php

class Dessert {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllDesserts() {
        $stmt = $this->pdo->query("SELECT * FROM desserts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDessert($name, $description, $price, $category_id, $image, $vegan) {
        $stmt = $this->pdo->prepare("INSERT INTO desserts (name, description, price, category_id, image, vegan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $category_id, $image, $vegan]);
    }
}