<?php
session_start();
require 'db_connection.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$currentUserId = $_SESSION['user_id'];
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll();
if (isset($_POST['delete'])) {
    $userIdToDelete = $_POST['user_id'];

    if ($userIdToDelete != $currentUserId) {
        $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $deleteStmt->execute([$userIdToDelete]);
    } else {
        echo "<script>alert('Вы не можете удалить своего собственного аккаунт.');</script>";
    }

    header("Location: admin.php");
    exit();
}

if (isset($_POST['edit'])) {
    $userIdToEdit = $_POST['user_id'];
    $newRole = $_POST['role'];

    if ($userIdToEdit != $currentUserId) {
        $updateStmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $updateStmt->execute([$newRole, $userIdToEdit]);
    } else {
        echo "<script>alert('Вы не можете изменить свою собственную роль.');</script>";
    }

    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Управление пользователями</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <div class="container">
        <a href="/index.php" class="btn-primary banner__link">Главная</a><br>
        <h2 style="text-align: center;">Управление пользователями</h2>

        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']); ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['role']); ?></td>
                        <td>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                                <select name="role">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>Пользователь</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Администратор</option>
                                </select>
                                <button type="submit" name="edit">Изменить роль</button>
                            </form>
                            <form action="" method="post" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                                <button type="submit" name="delete" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>