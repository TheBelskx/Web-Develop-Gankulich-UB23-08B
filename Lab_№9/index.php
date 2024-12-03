<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Портфолио</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Добро пожаловать в мое портфолио!</h1>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Вы авторизированы как <?= htmlspecialchars($_SESSION['role']); ?></p>
        <a href="profile.php">Мой профиль</a> |
        <a href="logout.php">Выйти</a>
        
        <?php if ($_SESSION['role'] === 'admin'): ?>
            | <a href="admin.php">Управление пользователями</a>
        <?php endif; ?>
        
    <?php else: ?>
        <a href="register.php">Регистрация</a> |
        <a href="login.php">Вход</a>
    <?php endif; ?>
    
</div>
</body>
</html>
