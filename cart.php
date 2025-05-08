<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once __DIR__ . '/../includes/functions.php';  // Исправленный путь
require_once '../config/database.php';  // Подключение к базе данных

$cart = $_SESSION['cart'] ?? [];

echo "<h2>Ваша корзина</h2>";

if (empty($cart)) {
    echo "<p>Корзина пуста.</p>";
} else {
    $total = 0;

    echo "<table class='table table-bordered'>";
    echo "<thead><tr><th>Название</th><th>Количество</th><th>Цена</th><th>Сумма</th></tr></thead><tbody>";

    foreach ($cart as $item) {
        $dessert_id = $item['dessert_id'] ?? null;
        $qty = $item['quantity'] ?? 0;

        if (empty($dessert_id) || $qty <= 0) {
            echo "<p>Ошибка: отсутствуют данные для десерта или количество некорректно.</p>";
            continue;
        }

        // Запрос к базе данных для получения названия и цены десерта по его ID
        try {
            $stmt = $pdo->prepare("SELECT name, price FROM desserts WHERE id = ?");
            $stmt->execute([$dessert_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $name = $row['name'];
            $price = $row['price'];
        } catch (PDOException $e) {
            die("Ошибка при выполнении запроса: " . $e->getMessage());
        }

        if ($name && $price) {
            $sum = $qty * $price;
            $total += $sum;

            echo "<tr>
                    <td>" . htmlspecialchars($name) . "</td>
                    <td>$qty</td>
                    <td>" . number_format($price, 2) . "</td>
                    <td>" . number_format($sum, 2) . "</td>
                  </tr>";
        } else {
            echo "<p>Ошибка: не удалось найти десерт с ID $dessert_id.</p>";
        }
    }

    echo "<tr><td colspan='3'><strong>Итого</strong></td><td><strong>" . number_format($total, 2) . "</strong></td></tr>";
    echo "</tbody></table>";
    echo "<a href='checkout.php' class='btn btn-success'>Оформить заказ</a>";
}

require_once '../includes/footer.php';  // Подключаем подвал сайта
?>
