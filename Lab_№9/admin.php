<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$currentUserId = $_SESSION['user_id']; // ID текущего администратора

// Логика для отображения и управления пользователями
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();

// Обработка удаления пользователя
if (isset($_POST['delete'])) {
    $userIdToDelete = $_POST['user_id'];

    // Проверка, не пытается ли администратор удалить самого себя
    if ($userIdToDelete != $currentUserId) {
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $deleteStmt->execute([$userIdToDelete]);
    } else {
        echo "<script>alert('Вы не можете удалить своего собственного аккаунт.');</script>";
    }
    
    header("Location: admin.php"); // Перенаправление после удаления
    exit();
}

// Обработка изменения роли пользователя
if (isset($_POST['edit'])) {
    $userIdToEdit = $_POST['user_id'];
    $newRole = $_POST['role'];

    // Проверка, не пытается ли администратор изменить свою собственную роль
    if ($userIdToEdit != $currentUserId) {
        $updateStmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $updateStmt->execute([$newRole, $userIdToEdit]);
    } else {
        echo "<script>alert('Вы не можете изменить свою собственную роль.');</script>";
    }

    header("Location: admin.php"); // Перенаправление после редактирования
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Управление пользователями</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['username']); ?></td>
                <td><?= htmlspecialchars($user['email']); ?></td>
                <td><?= htmlspecialchars($user['role']); ?></td>
                <td>
                    <!-- Форма для редактирования роли -->
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                        <select name="role">
                            <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Пользователь</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Администратор</option>
                        </select>
                        <button type="submit" name="edit">Изменить роль</button>
                    </form>

                    <!-- Форма для удаления пользователя -->
                    <form action="" method="post" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                        <button type="submit" name="delete" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
</body>
</html>