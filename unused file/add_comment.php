<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
session_start();
include("../includes/connection.txt"); // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!$data) {
            throw new Exception("Invalid input data.");
        }
    $postId = $data['postId'];
    $commentText = $data['commentText'];
    $parentCommentId = $data['parentCommentId'] ?? null; // For replies
    $userId = $_SESSION['user_id']; // Get the user ID from the session

    // Insert comment into the database
    $stmt = $pdo->prepare("
        INSERT INTO comments (user_id, post_id, comment_text, parent_comment_id)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$userId, $postId, $commentText, $parentCommentId]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>