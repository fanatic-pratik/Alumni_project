<?php
session_start();
include("../includes/connection.txt");
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
    $stmt->execute([$postId]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        echo json_encode($post);
    } else {
        echo json_encode(['error' => 'Post not found.']);
    }
}
?>
