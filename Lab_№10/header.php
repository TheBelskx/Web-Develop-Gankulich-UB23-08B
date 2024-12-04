<?php
session_start(); 
require_once 'db_connection.php'; 

if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $userRole = isset($user['role']) ? $user['role'] : ''; 
} else {
    $userRole = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title ?? 'Главная' ?></title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/project.css">
</head>
<body>
<header id="header-section">
        <div class="container">
            <div class="header">
                <nav class="nav-main">
                    <ul class="nav-main__list">
                        <li class="nav-main__item">
                            <a class="nav-main__link" href="index.php">Главная</a>
                        </li>
                        <li class="nav-main__item">
                            <a class="nav-main__link" href="project.php">Проекты</a>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-main__item">
                                <a class="nav-main__link" href="profile.php">Мой профиль</a>
                            </li>
                            <?php if ($userRole === 'admin'): ?>
                                <li class="nav-main__item">
                                    <a class="nav-main__link" href="/admin.php">Управление</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn-primary header__btn" href="/login.php">Авторизация/Регистрация</a>
                <?php else: ?>
                    <a class="btn-primary header__btn" href="logout.php">Выход</a>
                <?php endif; ?>
            </div>
            <div class="header1">
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">Меню</button>
                    <div id="myDropdown" class="dropdown-content">
                      <a href="index.php">Главная</a>
                      <a href="project.php">Проекты</a>
                      <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="profile.php">Мой профиль</a>
                        <?php if ($userRole === 'admin'): ?>
                            <a href="/admin.php">Управление</a>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                </div>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a class="btn-primary1 header__btn1" href="/login.php">Авторизация/Регистрация</a>
                <?php else: ?>
                    <a class="btn-primary1 header__btn1" href="/logout.php">Выход</a>
                <?php endif; ?>
            </div>
        </div>
    </header>