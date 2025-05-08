<?php
class CartController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addToCart() {
        $id = $_POST['id'] ?? null;

        if (!$id) {
            header('Location: /');
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }

        header('Location: /cart');
        exit;
    }

    public function showCart() {
        require 'views/cart.php';
    }

    public function removeFromCart() {
        $id = $_POST['id'] ?? null;

        if ($id && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        header('Location: /cart');
        exit;
    }
}


