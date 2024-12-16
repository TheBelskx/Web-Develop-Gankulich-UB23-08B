<?php
$title = 'Проекты';
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php";

session_start();
$isLoggedIn = isset($_SESSION['user_id']) && $_SESSION['user_id'];
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Обработка удаления проекта
if ($isAdmin && isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$deleteId]);
    } catch (PDOException $e) {
        echo "Error deleting project: " . $e->getMessage();
    }
    header("Location: " . $_SERVER['PHP_SELF']); // Перезагрузка текущей страницы
    exit();
}

// Обработка добавления проекта
if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title']) && isset($_POST['img']) && isset($_POST['link'])) {
    $title = $_POST['title'];
    $img = $_POST['img'];
    $link = $_POST['link'];
    
    if (!empty($title) && !empty($img) && !empty($link)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO projects (title, img, link) VALUES (?, ?, ?)");
            $stmt->execute([$title, $img, $link]);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } catch (PDOException $e) {
            echo "Error adding project: " . $e->getMessage();
        }
    } else {
        echo "Please fill all fields.";
    }
}

// Обработка добавления комментария
if ($isLoggedIn && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_text']) && isset($_POST['project_id'])) {
    $commentText = $_POST['comment_text'];
    $projectId = $_POST['project_id'];

    if (!empty($commentText)) {
        try {
          $stmt = $pdo->prepare("INSERT INTO project_comments (project_id, user_id, comment_text, created_at) VALUES (?, ?, ?, NOW())");
          $stmt->execute([$projectId, $userId, $commentText]);
          header("Location: " . $_SERVER['PHP_SELF']); // Перезагрузка текущей страницы
          exit();
        } catch (PDOException $e) {
            echo "Error adding comment: " . $e->getMessage();
        }
    }
}
// Обработка удаления комментария (для администратора)
if($isAdmin && isset($_GET['delete_comment_id']) && isset($_GET['project_id'])){
    $commentId = $_GET['delete_comment_id'];
    $projectId = $_GET['project_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM project_comments WHERE id = ?");
        $stmt->execute([$commentId]);
         header("Location: " . $_SERVER['PHP_SELF']); // Перезагрузка текущей страницы
        exit();
    } catch (PDOException $e) {
        echo "Error deleting comment: " . $e->getMessage();
    }
}
?>

<section class="cars__title">
    <div class="container">
        Все мои проекты за год
    </div>
</section>

<div class="cars__cars">
    <div class="container">
        <div class="cars__cards">

<?php
// Получение проектов из БД
try {
    $stmt = $pdo->query("SELECT * FROM projects");
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    $projects = [];
}

foreach ($projects as $project) {
?>
            <div class="cars__card">
                <div class="cars__card-img">
                    <img src="<?= htmlspecialchars($project['img']) ?>" alt="<?= htmlspecialchars($project['title']) ?>">
                </div>
                <div class="cars__card-title">
                    <?= htmlspecialchars($project['title']) ?>
                </div>
                <div class="cars__card-button">
                    <?php if ($isLoggedIn): ?>
                        <a href="<?= htmlspecialchars($project['link']) ?>" class="btn-primary" target="_blank">Открыть проект</a>
                    <?php else: ?>
                        <a onclick="showErrorMessage()" class="btn-primary">Смотреть</a>
                    <?php endif; ?>
                </div>
                <div class="cars__card-discussion">
                    <h3>Обсуждение</h3>
                   <?php
                        // Получение комментариев
                        $stmt = $pdo->prepare("SELECT pc.id, pc.comment_text, pc.created_at, u.username FROM project_comments pc JOIN users u ON pc.user_id = u.id WHERE project_id = ? ORDER BY created_at DESC");
                        $stmt->execute([$project['id']]);
                        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $commentCount = count($comments); // получаем количество комментариев
                        
                       if($commentCount > 0):
                        foreach ($comments as $index => $comment) {
                            $isLastComment = $index === 0; // Определяем, является ли комментарий последним.
                            ?>
                            <div class="comment <?= $isLastComment ? '' : 'hidden-comments' ?>">  <!-- Добавляем класс hidden-comments ко всем кроме последнего -->
                            <p><strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= htmlspecialchars($comment['comment_text']) ?> </p>
                            <small><?= htmlspecialchars($comment['created_at']) ?></small>
                             <?php if($isAdmin): ?>
                                 <a href="?delete_comment_id=<?= $comment['id'] ?>&project_id=<?= $project['id'] ?>" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?')">Удалить</a>
                             <?php endif; ?>
                             </div>
                          <?php
                        }
                        if($commentCount > 1): // Если есть более 1 комментария
                            ?>
                            <button class="show-all-comments-btn">Показать все комментарии</button>
                           <?php
                        endif;
                       else:
                         echo "<p>Пока нет ни одного комментария.</p>";
                       endif;
                    ?>
                    
                    <?php if ($isLoggedIn): ?>
                        <form method="post" class="add-comment-form">
                            <input type="hidden" name="project_id" value="<?= $project['id'] ?>">
                              <div class="form-group">
                                  <label for="comment_text">Ваш комментарий</label>
                                  <textarea name="comment_text" id="comment_text" required></textarea>
                             </div>
                            <button type="submit" class="btn-primary">Отправить</button>
                        </form>
                    <?php else: ?>
                        <p>Для добавления комментария необходимо авторизоваться.</p>
                    <?php endif; ?>
                </div>
            </div>
<?php
}
?>

        </div>
         <?php if ($isAdmin): ?>
           
           <h2>Управление проектами</h2>
            <table class="projects-table">
              <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Изображение</th>
                        <th>Ссылка</th>
                        <th>Действия</th>
                   </tr>
                 </thead>
                <tbody>
                   <tr>
                        <td colspan="5">
                             <h3>Добавить новый проект</h3>
                                <form method="post"  class="add-project-form">
                                  <div class="form-group">
                                       <label for="title">Название проекта</label>
                                        <input type="text" name="title" id="title" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="img">Ссылка на изображение проекта</label>
                                        <input type="text" name="img" id="img" required>
                                    </div>
                                     <div class="form-group">
                                         <label for="link">Ссылка на проект</label>
                                          <input type="text" name="link" id="link" required>
                                     </div>
                                    <button type="submit" class="btn-primary">Добавить</button>
                                </form>
                          </td>
                  </tr>
                 <?php foreach ($projects as $project): ?>
                    <tr>
                        <td><?= htmlspecialchars($project['id']) ?></td>
                         <td><?= htmlspecialchars($project['title']) ?></td>
                         <td><img src="<?= htmlspecialchars($project['img']) ?>" alt="<?= htmlspecialchars($project['title']) ?>" style="max-width: 50px; max-height: 50px;"></td>
                         <td><a href="<?= htmlspecialchars($project['link']) ?>" target="_blank">Ссылка</a></td>
                         <td>
                               <a href="?delete_id=<?= $project['id'] ?>" class="btn-delete" onclick="return confirm('Вы уверены, что хотите удалить этот проект?')">Удалить</a>
                         </td>
                    </tr>
                 <?php endforeach; ?>
                </tbody>
             </table>

        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . "/footer.php"; ?>

<script>
function showErrorMessage() {
    alert("Только авторизованные пользователи могут получить доступ.");
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.show-all-comments-btn').forEach(button => {
        button.addEventListener('click', function() {
          const card = this.closest('.cars__card');
          if(card){
             const hiddenComments = card.querySelectorAll('.hidden-comments');
              hiddenComments.forEach(comment => {
                  comment.classList.remove('hidden-comments');
              });
              this.style.display = 'none'; // Прячем кнопку
          }
        });
    });
});
</script>
<style>
    .projects-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .projects-table th, .projects-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .projects-table th {
        background-color: #f2f2f2;
    }
    .btn-delete {
        background-color: #f44336;
        color: white;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 4px;
    }

    .btn-delete:hover {
        background-color: #d32f2f;
    }
  .add-project-form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: flex-end;

  }
  .add-project-form .form-group {
        flex: 1 1 200px;
   }
  .add-project-form label{
    display: block;
  }
  .cars__card-discussion{
      margin-top: 20px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
  .add-comment-form{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
         align-items: flex-end;
    }
  .add-comment-form .form-group {
       flex: 1 1 100px;
    }
    .comment{
        border-bottom: 1px solid #ddd;
        padding: 5px 0;
    }
    .hidden-comments {
        display: none;
    }
    .show-all-comments-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    .show-all-comments-btn:hover {
        background-color: #45a049;
    }
</style>