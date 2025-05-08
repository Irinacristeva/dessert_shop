<?php
require_once 'config/database.php';

$upload_dir = 'uploads/images/';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? '';
    $description = $_POST['description'] ?? '';

    // Обработка файла
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file; // сохраняем как uploads/images/файл

            // Сохраняем в БД
            $stmt = $pdo->prepare("INSERT INTO desserts (name, price, description, image) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $price, $description, $image_path]);

            $message = "Десерт успешно добавлен!";
        } else {
            $message = "Ошибка при загрузке изображения.";
        }
    } else {
        $message = "Пожалуйста, загрузите фотографию.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить десерт</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Добавить десерт</h2>
        <?php if ($message): ?>
            <p><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="add-dessert.php" method="POST" enctype="multipart/form-data">
            <label>Название десерта:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Фотография десерта:</label><br>
            <input type="file" name="image" accept="image/*" required><br><br>

            <label>Цена (₽):</label><br>
            <input type="number" name="price" step="0.01" required><br><br>

            <label>Краткое описание:</label><br>
            <textarea name="description" rows="4" cols="40" required></textarea><br><br>

            <input type="submit" value="Добавить">
        </form>
    </div>
</body>
</html>
