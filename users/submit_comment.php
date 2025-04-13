<?php
session_start();
include('../includes/connection.txt'); // Update path if needed

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$content = trim($_POST['content']);
$parent_id = !empty($_POST['parent_id']) ? $_POST['parent_id'] : null;

if (!$content) exit;

$stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, parent_comment_id, content) VALUES (?, ?, ?, ?)");
$stmt->execute([$post_id, $user_id, $parent_id, $content]);

echo "success";
?>