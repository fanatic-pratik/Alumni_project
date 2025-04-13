<?php
session_start();
include("../includes/connection.txt");
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ?, status = 'pending', updated_at = NOW() WHERE post_id = ?");
    $stmt->execute([$title, $content, $postId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Post updated and sent for admin review.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes made or post not found.']);
    }
}
?>
