<?php
require_once 'config/database.php';
session_start();

try {
    $stmt = $pdo->query("SELECT * FROM desserts");
    $desserts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка при получении десертов: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Наши десерты</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Наши десерты</h1>

        <!-- Контейнер для десертов -->
        <div class="desserts">
    <?php foreach ($desserts as $dessert): ?>
        <div class="dessert">
            <?php if (!empty($dessert['image'])): ?>
                <img src="uploads/images/<?php echo htmlspecialchars($dessert['image']); ?>" alt="<?php echo htmlspecialchars($dessert['name']); ?>">
            <?php else: ?>
                <img src="assets/img/placeholder.jpg" alt="Нет изображения">
            <?php endif; ?>

            <h3><?php echo htmlspecialchars($dessert['name']); ?></h3>
            <p><?php echo htmlspecialchars($dessert['description']); ?></p>
            <p><strong><?php echo number_format($dessert['price'], 2); ?> ₽</strong></p>

            <?php if (isset($_SESSION['username'])): ?>
                <form method="POST" action="add-to-cart.php">
                    <input type="hidden" name="dessert_id" value="<?php echo $dessert['id']; ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" name="add_to_cart" class="btn">Добавить в корзину</button>
                </form>
            <?php else: ?>
                <p><a href="login.php">Войдите</a>, чтобы добавить в корзину.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<form method="POST" action="add-to-cart.php">
    <input type="hidden" name="dessert_id" value="<?php echo $dessert['id']; ?>">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" name="add_to_cart" class="btn">Добавить в корзину</button>
</form>



</body>
</html>
