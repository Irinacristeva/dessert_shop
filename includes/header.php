<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Dessert Shop</title>
    <link rel="stylesheet" href="/dessert_shop/assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/dessert_shop/index.php">Dessert Shop</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                <li class="nav-item"><a class="nav-link" href="/dessert_shop/views/cart.php">Корзина</a></li>
                <li class="nav-item"><a class="nav-link" href="/dessert_shop/welcome.php">Профиль</a></li>
                <li class="nav-item"><a class="nav-link" href="/dessert_shop/logout.php">Выйти</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="/dessert_shop/login.php">Войти</a></li>
                <li class="nav-item"><a class="nav-link" href="/dessert_shop/register.php">Регистрация</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<div class="container mt-4">
