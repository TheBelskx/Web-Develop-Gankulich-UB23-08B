<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    
    $currentDate = new DateTime();
    $birthDate = new DateTime($birth_date);
    if ($birthDate > $currentDate) {
        $_SESSION['error'] = "Дата рождения не может быть больше текущей даты!";
        header("Location: register.php");
        exit();
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $_SESSION['error'] = "Имя пользователя уже используется!";
        header("Location: register.php"); 
        exit();
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $emailCount = $stmt->fetchColumn();

    if ($emailCount > 0) {
        $_SESSION['error'] = "Email уже используется!";
        header("Location: register.php");
        exit();
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, email, birth_date) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $password, $email, $birth_date])) {
            $_SESSION['success'] = "Регистрация прошла успешно!";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Ошибка регистрации!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/css/register.css">
    <style>
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Регистрация</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Имя пользователя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="date" name="birth_date" max="<?= date('Y-m-d') ?>" required>  
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit">Зарегистрироваться</button>
    </form>
</div>
</body>
</html>