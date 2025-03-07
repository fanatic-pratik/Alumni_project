<?php
session_start();
include("../includes/connection.txt");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = json_decode(file_get_contents('php://input'), true)['postId'];
    $userId = $_SESSION['user_id'];

    // Check if the user already liked the post
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ? AND like_dislike = 1");
    $stmt->execute([$userId, $postId]);

    if ($stmt->rowCount() === 0) {
        // Insert like
        $stmt1 = $pdo->prepare("INSERT INTO likes (user_id, post_id,like_dislike) VALUES (?, ?, ?)");
        $stmt1->execute([$userId, $postId, 1]);
    } else {
        // Remove like
        $stmt1 = $pdo->prepare("UPDATE likes SET like_dislike=0 WHERE user_id = ? AND post_id = ? AND like_dislike = 1");
        $stmt1->execute([$userId, $postId]);
    }

    // Get updated like count
    $stmt2 = $pdo->prepare("SELECT COUNT(*) as likeCount FROM likes WHERE post_id = ? AND like_dislike = 1");
    $stmt2->execute([$postId]);
    $likeCount = $stmt2->fetch()['likeCount'];

    echo json_encode(['success' => true, 'likeCount' => $likeCount]);
}
?>