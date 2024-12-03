<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];

    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, birth_date) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $password, $email, $birth_date])) {
        $_SESSION['success'] = "Регистрация прошла успешно!";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Ошибка регистрации!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Регистрация</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Почта" required>
        <input type="date" name="birth_date" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
</body>
</html>