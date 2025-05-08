<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dessert_id'])) {
    $dessert_id = $_POST['dessert_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Убедимся, что текущий десерт в корзине — это не массив
    if (isset($_SESSION['cart'][$dessert_id]) && is_numeric($_SESSION['cart'][$dessert_id])) {
        $_SESSION['cart'][$dessert_id] += $quantity;
    } else {
        $_SESSION['cart'][$dessert_id] = $quantity;
    }

    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
