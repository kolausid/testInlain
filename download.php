<?php
require 'connectDb.php';

$postUrl = 'https://jsonplaceholder.typicode.com/posts';
$commentUrl = 'https://jsonplaceholder.typicode.com/comments';

$postJson = file_get_contents($postUrl);
$commentJson = file_get_contents($commentUrl);

if ($postJson === false or $commentJson === false) {
    die('Ошибка загрузки Json');
}

$arrPost = json_decode($postJson, true);
$arrComment = json_decode($commentJson, true);

if (json_last_error() != JSON_ERROR_NONE) {
    die('Ошибка разбора Json: ' . json_last_error_msg());
}

$stmtPost = $pdo->prepare("INSERT INTO posts (id, userId, title, body) VALUES (?, ?, ?, ?)");

$stmtComment = $pdo->prepare("INSERT INTO comments (id, postId, name, email, body) VALUES (?, ?, ?, ?, ?)");

$postCount = 0;
$commentCount = 0;

foreach($arrPost as $post) {
    $stmtPost->execute([
        $post['id'],
        $post['userId'],
        $post['title'],
        $post['body']
    ]);
    $postCount++;
}

foreach($arrComment as $comment) {
    $stmtComment->execute([
        $comment['id'],
        $comment['postId'],
        $comment['name'],
        $comment['email'],
        $comment['body']
    ]);
    $commentCount++;
}

echo "Загружено $postCount постов и $commentCount комментариев";




?>