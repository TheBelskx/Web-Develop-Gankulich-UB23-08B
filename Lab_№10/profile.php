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

$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_password']) && isset($_POST['new_password'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    if (password_verify($oldPassword, $user['password'])) {
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedNewPassword, $user_id]);
        $successMessage = "Пароль успешно изменен!";
    } else {
        $errorMessage = "Неверный старый пароль!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой профиль</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
<div class="container">
    <h2>Профиль пользователя</h2>

    <?php if ($successMessage): ?>
        <div class="success-message"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
        <div class="error-message"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <a href="index.php" class="button">На главную</a> <br><br>
    <p>Имя: <?= htmlspecialchars($user['username']); ?></p>
    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
    <p>Дата рождения: <?= htmlspecialchars($user['birth_date']); ?></p>
    <p>Время регистрации: <?= htmlspecialchars($user['created_at']); ?></p>

    <h3>Изменить пароль</h3>
    <form method="post">
        <label for="old_password">Старый пароль:</label>
        <input type="password" id="old_password" name="old_password" required><br>
        <label for="new_password">Новый пароль:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <button type="submit">Изменить пароль</button>
    </form>
</div>
</body>
</html>