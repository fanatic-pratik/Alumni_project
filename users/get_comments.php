<?php
session_start();
include("../includes/connection.txt"); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = json_decode(file_get_contents('php://input'), true)['postId'];

    // Fetch top-level comments and their replies
    $stmt = $pdo->prepare("
        SELECT c.*, u.name as username
        FROM comments c
        JOIN users u ON c.user_id = u.user_id
        WHERE c.post_id = ? AND c.parent_comment_id IS NULL
        ORDER BY c.created_at DESC
    ");
    $stmt->execute([$postId]);
    $comments = $stmt->fetchAll();

    // Fetch replies for each comment
    foreach ($comments as &$comment) {
        $stmt = $pdo->prepare("
            SELECT c.*, u.name as username
            FROM comments c
            JOIN users u ON c.user_id = u.user_id
            WHERE c.parent_comment_id = ?
            ORDER BY c.created_at ASC
        ");
        $stmt->execute([$comment['id']]);
        $comment['replies'] = $stmt->fetchAll();
    }

    echo json_encode(['success' => true, 'comments' => $comments]);
}
?>