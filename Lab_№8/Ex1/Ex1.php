<!DOCTYPE html>
<html>
<head>
<title>Таблица умножения</title>
<style>
body {
  font-family: sans-serif;
}
table {
  width: 50%;
  margin: 20px auto;
  border-collapse: collapse;
  border: 1px solid #ddd;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}
th {
  background-color: #f2f2f2;
}
</style>
</head>
<body>

<h1>Таблица умножения (0-10)</h1>

<table>
  <tr>
    <th></th>
    <?php for ($i = 0; $i <= 10; $i++): ?>
      <th><?php echo $i; ?></th>
    <?php endfor; ?>
  </tr>
  <?php for ($i = 0; $i <= 10; $i++): ?>
    <tr>
      <th><?php echo $i; ?></th>
      <?php for ($j = 0; $j <= 10; $j++): ?>
        <td><?php echo $i * $j; ?></td>
      <?php endfor; ?>
    </tr>
  <?php endfor; ?>
</table>

</body>
</html>