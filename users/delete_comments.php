<?php
session_start();
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
include('../includes/connection.txt');

if (!isset($user_id)) {
    http_response_code(401);
    echo "Unauthorized";
    exit;
}
if (!isset($_POST['comment_id'])) {
    http_response_code(400);
    echo "Missing comment_id";  // This message will help us debug
    exit;
}
$comment_id = $_POST['comment_id']; // Retrieve the comment_id

// Check if the comment exists in the database
$stmt = $pdo->prepare("SELECT * FROM comments WHERE comment_id = ?");
$stmt->execute([$comment_id]);
$comment = $stmt->fetch();

if (!$comment) {
    http_response_code(404);
    echo "Comment not found";
    exit;
}

// Check if the user is the owner or an admin
if ($comment['user_id'] != $user_id && $role != 'admin') {
    http_response_code(403);
    echo "Permission denied";
    exit;
}

// Recursive delete of all nested replies
function deleteReplies($pdo, $parent_id) {
    $stmt = $pdo->prepare("SELECT comment_id FROM comments WHERE parent_comment_id = ?");
    $stmt->execute([$parent_id]);
    $children = $stmt->fetchAll();

    foreach ($children as $child) {
        deleteReplies($pdo, $child['comment_id']); // Recursively delete replies
    }

    // Now delete the comment itself
    $stmt = $pdo->prepare("DELETE FROM comments WHERE comment_id = ?");
    $stmt->execute([$parent_id]);
}

// Delete the selected comment and its replies
deleteReplies($pdo, $comment_id);

echo "Deleted";
?>