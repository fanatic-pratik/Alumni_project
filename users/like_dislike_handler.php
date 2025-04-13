<?php
session_start();
include('../includes/connection.txt');

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$type = $_POST['type']; // like or dislike

if (!in_array($type, ['like', 'dislike', 'none'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid type']);
    exit;
}

// Check if already reacted
$stmt = $pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
$stmt->execute([$user_id, $post_id]);
$existing = $stmt->fetch();

if ($existing) {
    // If the user clicks the same reaction (like or dislike), remove it (set to null or delete)
    if ($existing['type'] === $type) {
        // Remove reaction (set to NULL or delete the record)
        $stmt = $pdo->prepare("DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
        $type = 'none';  // Indicating no reaction
    } else {
        // Update the reaction (changing like/dislike)
        $stmt = $pdo->prepare("UPDATE post_likes SET type = ?, created_at = NOW() WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$type, $user_id, $post_id]);
    }
} else {
    // Insert new reaction
    $stmt = $pdo->prepare("INSERT INTO post_likes (user_id, post_id, type) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $post_id, $type]);
}

// Get updated counts
$stmt = $pdo->prepare("SELECT 
    SUM(type = 'like') AS likes, 
    SUM(type = 'dislike') AS dislikes 
    FROM post_likes WHERE post_id = ?");
$stmt->execute([$post_id]);
$counts = $stmt->fetch();

// Send the response back with the updated reaction counts
echo json_encode([
    'success' => true,
    'likes' => $counts['likes'],
    'dislikes' => $counts['dislikes'],
    'reaction' => $type // Send back the current reaction (none if neutralized)
]);
