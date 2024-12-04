<?php
$title = 'Проекты';
require_once __DIR__ . "/header.php"; 

session_start();
$isLoggedIn = isset($_SESSION['user_id']) && $_SESSION['user_id'];
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
$projects = [
    ['title' => 'MobWars', 'img'            => 'img/main/MobWars.jpg', 'link' => 'https://gitlab.com/belsky.official/MobWars-Online'],
    ['title' => 'TopDownShooter', 'img'     => 'img/main/TopDownShooter.jpg', 'link' => 'https://gitlab.com/belsky.official/Top-Down-Shooter'],
    ['title' => 'TheSnake', 'img'           => 'img/main/TheSnake.jpg', 'link' => 'https://gitlab.com/belsky.official/20-Homework'],
    ['title' => 'TheArcanoid', 'img'        => 'img/main/Arcanoid.jpg', 'link' => 'https://gitlab.com/belsky.official/TheFinal-Arcanoid'],
    ['title' => 'C++ Patterns', 'img'       => 'img/main/Patterns.jpg', 'link' => 'https://gitlab.com/belsky.official/Middle-Module'],
    ['title' => 'Mobile Cliecker', 'img'    => 'img/main/ClieckerMobile.jpg', 'link' => 'https://gitlab.com/belsky.official/Mobile-Clicker'],
];

foreach ($projects as $project) {
?>
            <div class="cars__card">
                <div class="cars__card-img">
                    <img src="<?= $project['img'] ?>" alt="<?= $project['title'] ?>">
                </div>
                <div class="cars__card-title">
                    <?= $project['title'] ?>
                </div>
                <div class="cars__card-button">
                    <?php if ($isLoggedIn): ?>
                        <a href="<?= $project['link'] ?>" class="btn-primary" target="_blank">Открыть проект</a>
                    <?php else: ?>
                        <a onclick="showErrorMessage()" class="btn-primary">Смотреть</a>
                    <?php endif; ?>
                </div>
            </div>

<?php } ?>

        </div>
    </div>
</div>



<?php require_once __DIR__ . "/footer.php"; ?>


<script>
function showErrorMessage() {
    alert("Только авторизованные пользователи могут получить доступ.");
}
</script>