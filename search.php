<?php
require 'connectDb.php';


$searchTermin = '';
$results = [];


if (isset($_GET['search'])) {
    $searchTermin = trim($_GET['search']);

    if (!empty($searchTermin)) {
        $stmt = $pdo->prepare("
            SELECT p.title, c.body AS comment_body
            FROM comments c
            JOIN posts p ON c.postId = p.id
            WHERE MATCH(c.body) AGAINST(? IN NATURAL LANGUAGE MODE)
        ");
        $stmt->execute([$searchTermin]);
        $results = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск комментариев</title>
</head>
<body>

<h2>Поиск комментариев</h2>

<form method="GET" action="">
    <label for="search">Введите слово:</label>
    <input type="text" name="search" id="search" value="<?= htmlspecialchars($searchTermin) ?>" required>
    <button type="submit">Найти</button>
</form>

<?php if ($searchTermin && empty($results)): ?>
    <p>Ничего не найдено.</p>
<?php elseif (!empty($results)): ?>
    <h3>Результаты:</h3>
    <ul>
        <?php foreach ($results as $row): ?>
            <li><strong><?= htmlspecialchars($row['title']) ?>:</strong> <?= htmlspecialchars($row['comment_body']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

</body>
</html>