<?php
session_start();
require_once '../includes/functions.php';
require_once '../includes/header.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Ваша корзина пуста.</p>";
    require_once '../includes/footer.php';
    exit;
}

// Очистка корзины после оформления
unset($_SESSION['cart']);

echo "<h2>Спасибо за заказ!</h2>";
echo "<p>Ваш заказ был успешно оформлен.</p>";

require_once '../includes/footer.php';
