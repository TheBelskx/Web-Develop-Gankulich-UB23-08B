<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Календарь на месяц</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .weekend {
            background-color: #f2a2a2; /* Цвет для выходных */
        }

        .holiday {
            background-color: #ffd700; /* Цвет для праздничных дней */
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Календарь на месяц</h1>

<form method="GET">
    <label for="month">Месяц:</label>
    <select name="month" id="month">
        <?php
        for ($m = 1; $m <= 12; $m++) {
            echo "<option value='$m'>$m</option>";
        }
        ?>
    </select>

    <label for="year">Год:</label>
    <input type="number" name="year" id="year" value="<?php echo date('Y'); ?>" min="1900" max="2100" required>

    <button type="submit">Показать календарь</button>
</form>

<?php
function drawCalendar($month = null, $year = null) {
    // Если параметры не заданы, используем текущий месяц и год
    if (is_null($month) || is_null($year)) {
        $month = date('n'); // Текущий месяц
        $year = date('Y');  // Текущий год
    }

    // Определяем количество дней в месяце и первый день месяца
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
    $firstWeekday = date('w', $firstDayOfMonth); // День недели первого числа месяца

    // Праздничные дни (пример)
    $holidays = [
        "$year-01-01", // Новый год
        "$year-05-01", // Праздник весны и труда
        "$year-12-25", // Рождество
    ];

    echo '<table>';
    echo '<tr>';
    echo '<th>Пн</th><th>Вт</th><th>Ср</th><th>Чт</th><th>Пт</th><th>Сб</th><th>Вс</th>';
    echo '</tr><tr>';

    // Добавляем пустые ячейки до первого дня месяца
    for ($i = 0; $i < $firstWeekday; $i++) {
        echo '<td></td>';
    }

    // Заполняем календарь днями месяца
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $currentDate = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
        $class = '';

        // Проверяем выходные и праздничные дни
        if (in_array($currentDate, $holidays)) {
            $class = 'holiday';
        } elseif ($firstWeekday == 6 || $firstWeekday == 0) { // Суббота или Воскресенье
            $class = 'weekend';
        }

        echo "<td class='$class'>$day</td>";

        // Переход на новую строку после воскресенья
        if ($firstWeekday == 6) {
            echo '</tr><tr>';
            $firstWeekday = -1; // Сброс счетчика на следующую неделю
        }
        $firstWeekday++;
    }

    // Закрываем оставшиеся ячейки в строке
    while ($firstWeekday < 7) {
        echo '<td></td>';
        $firstWeekday++;
    }

    echo '</tr>';
    echo '</table>';
}

// Проверяем, были ли переданы параметры month и year через GET-запрос
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = (int)$_GET['month'];
    $year = (int)$_GET['year'];
    drawCalendar($month, $year);
} else {
    drawCalendar(); // По умолчанию текущий месяц и год
}
?>

</body>
</html>