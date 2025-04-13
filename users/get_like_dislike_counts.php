<?php
include('../includes/connection.txt');
$post_id = $_GET['post_id'];

// Count the number of likes, dislikes, and neutral reactions (NULL)
$stmt = $pdo->prepare("SELECT 
    SUM(type = 'like') AS likes, 
    SUM(type = 'dislike') AS dislikes,
    COUNT(*) - SUM(type IS NOT NULL) AS neutral  -- This counts rows where type is NULL
    FROM post_likes WHERE post_id = ?");
$stmt->execute([$post_id]);
$counts = $stmt->fetch();

// Return the results with default 0 for missing values
echo json_encode([
    'likes' => $counts['likes'] ?? 0,
    'dislikes' => $counts['dislikes'] ?? 0,
    'neutral' => $counts['neutral'] ?? 0  // Neutral count
]);
