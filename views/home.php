<?php
session_start();

// Подключаем необходимые файлы
require_once 'functions.php';
require_once 'includes/db.php';

// Проверка авторизации
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}

// Получаем все десерты
$query = "SELECT * FROM desserts";
$result = mysqli_query($conn, $query);
?>

<link rel="stylesheet" href="assets/css/styles.css">

<div class="container">
    <h1 >Наши десерты</h1>
    <div class="desserts">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="dessert">
            <?php if (!empty($row['image'])): ?>
    <img src="uploads/images/<?php echo e($row['image']); ?>" alt="<?php echo e($row['name']); ?>" style="max-width: 200px; height: auto;">
<?php endif; ?>

                <p><?php echo e($row['description']); ?></p>
                <p>Цена: <?php echo e($row['price']); ?> ₽</p>
                <form action="add-to-cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo e($row['id']); ?>">
                    <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</div>
