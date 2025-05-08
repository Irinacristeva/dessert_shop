<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if (empty($username) || empty($password) || empty($confirm_password) || empty($email)) {
        $error = "Все поля должны быть заполнены!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Некорректный формат электронной почты!";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают!";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов!";
    } else {
        $query = "SELECT id FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "Пользователь с таким именем уже существует!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Ошибка регистрации. Попробуйте позже.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="my-4">Регистрация</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div class="form-group">
            <label for="username">Имя пользователя</label>
            <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Электронная почта</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Подтверждение пароля</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>

    <p class="mt-3">Уже есть аккаунт? <a href="login.php">Войдите здесь</a></p>
</div>
</body>
</html>
