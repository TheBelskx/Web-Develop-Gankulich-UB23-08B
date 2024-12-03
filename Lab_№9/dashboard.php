<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Добро пожаловать, <?= htmlspecialchars($user['username']); ?>!</h2>
    
    <p>Ваш email: <?= htmlspecialchars($user['email']); ?></p>
    <p>Дата рождения: <?= htmlspecialchars($user['birth_date']); ?></p>

    <h3>Ваши проекты:</h3>
    <ul>
        <!-- для будущей реализации проектов -->
        <li>Проект 1</li>
        <li>Проект 2</li>
        <li>Проект 3</li>
    </ul>

    <a href="profile.php">Редактировать профиль</a> |
    <a href="logout.php">Выйти</a>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        | <a href="admin.php">Управление пользователями</a>
    <?php endif; ?>
    
</div>
</body>
</html>