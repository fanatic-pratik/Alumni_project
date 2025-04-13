<?php
session_start();
include("../includes/connection.txt");

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];

    // First, delete related comments
    $deleteComments = $pdo->prepare("DELETE FROM comments WHERE post_id = ?");
    $deleteComments->execute([$postId]);

    // Then, delete the post itself
    $deletePost = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
    $deletePost->execute([$postId]);

    if ($deletePost->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Post not found or could not be deleted.']);
    }
}
?>
