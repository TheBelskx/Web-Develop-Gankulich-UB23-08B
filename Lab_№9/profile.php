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
    <title>Мой профиль</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Профиль пользователя</h2>
    
    <p>Имя: <?= htmlspecialchars($user['username']); ?></p>
    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
    <p>Дата рождения: <?= htmlspecialchars($user['birth_date']); ?></p>

    
    
</div>
</body>
</html>