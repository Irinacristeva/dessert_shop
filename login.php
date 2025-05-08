<?php
session_start();
require_once 'config/database.php';
$_SESSION['role'] = $user['role'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Все поля должны быть заполнены!";
    } else {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Неверное имя пользователя или пароль!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="my-4">Вход</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-group">
            <label for="username">Имя пользователя</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>

    <p class="mt-3">Нет аккаунта? <a href="register.php">Зарегистрируйтесь здесь</a></p>
</div>
</body>
</html>
