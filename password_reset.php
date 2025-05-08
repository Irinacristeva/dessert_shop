<?php
session_start();
require_once 'config/database.php';

// Проверка авторизации
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($new_password) || empty($confirm_password)) {
        $error = "Оба поля обязательны для заполнения.";
    } elseif (strlen($new_password) < 6) {
        $error = "Пароль должен содержать минимум 6 символов.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Пароли не совпадают.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $query = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success = "Пароль успешно обновлён. <a href='login.php'>Войти заново</a>";
            // Можно также сбросить сессию:
            session_destroy();
        } else {
            $error = "Не удалось обновить пароль. Повторите попытку позже.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сброс пароля</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Сброс пароля</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (!$success): ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="new_password">Новый пароль</label>
                <input type="password" class="form-control" name="new_password" id="new_password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Подтвердите пароль</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary">Сбросить пароль</button>
        </form>
    <?php endif; ?>

    <p class="mt-3"><a href="welcome.php">Назад</a></p>
</div>
</body>
</html>
