-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-8.0
-- Время создания: Дек 17 2024 г., 01:19
-- Версия сервера: 8.0.35
-- Версия PHP: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `user_management`
--

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE `projects` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `title`, `img`, `link`) VALUES
(7, 'MobWars', 'img/main/MobWars.jpg', 'https://gitlab.com/belsky.official/MobWars-Online'),
(8, 'TopDownShooter', 'img/main/TopDownShooter.jpg', 'https://gitlab.com/belsky.official/Top-Down-Shooter'),
(9, 'TheSnake', 'img/main/TheSnake.jpg', 'https://gitlab.com/belsky.official/20-Homework'),
(10, 'TheArcanoid', 'img/main/Arcanoid.jpg', 'https://gitlab.com/belsky.official/TheFinal-Arcanoid'),
(11, 'C++ Patterns', 'img/main/Patterns.jpg', 'https://gitlab.com/belsky.official/Middle-Module'),
(12, 'Mobile Cliecker', 'img/main/ClieckerMobile.jpg', 'https://gitlab.com/belsky.official/Mobile-Clicker');

-- --------------------------------------------------------

--
-- Структура таблицы `project_comments`
--

CREATE TABLE `project_comments` (
  `id` int NOT NULL,
  `project_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment_text` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `project_comments`
--

INSERT INTO `project_comments` (`id`, `project_id`, `user_id`, `comment_text`, `created_at`) VALUES
(5, 7, 14, 'Отличный проект!', '2024-12-16 18:15:44'),
(6, 7, 14, 'Мне очень понравился!', '2024-12-16 18:15:50'),
(7, 10, 14, 'Классный, простой проект!', '2024-12-16 18:16:02'),
(8, 11, 14, 'очень сложные паттерны!', '2024-12-16 18:16:12'),
(9, 7, 15, 'Очень похоже на MobWars из майнкрафта!', '2024-12-16 18:16:48'),
(10, 9, 15, 'Змейка шикарная!', '2024-12-16 18:16:59'),
(11, 8, 15, 'очень тяжелая и крутая игра!', '2024-12-16 18:17:06');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `birth_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `birth_date`) VALUES
(1, 'AGankulich-UB23', '$2y$10$tqSHePwL8t2BzVhjBsG4..RL1ikmHsAUWRs6nkfHbxP9wX8zMhQ2G', 'belsky.official@gmail.com', 'admin', '2024-12-04 06:27:54', '2005-01-12'),
(15, 'Andrey22', '$2y$10$9yUxr/JhVPB4N.swtpl0/uoOTLO0QoFnbQ5Md.RrfJXVuNJpYCY2O', 'Andrey22@mail.ru', 'user', '2024-12-16 18:16:31', '2005-12-12'),
(14, 'Gerasim22', '$2y$10$x7EHU9WFXGJKaZs05km5le70Dlqwfy04oM1PGb8QHXS5NVMLZ2Wpe', 'Gerasim22@mail.ru', 'user', '2024-12-16 18:10:26', '2005-12-12'),
(2, 'Gerasim', '$2y$10$J8mN/RwLpCwkFDYRqQh21O74VsLrR5EVIwxkA8NSFmwQnzSZYTLlS', 'Gerasim@mail.ru', 'user', '2024-12-05 02:00:32', '2000-02-12');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `project_comments`
--
ALTER TABLE `project_comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `project_comments`
--
ALTER TABLE `project_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
