<?php
session_start();
include("../includes/connection.txt");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = json_decode(file_get_contents('php://input'), true)['postId'];
    $userId = $_SESSION['user_id'];
    $reaction = json_decode(file_get_contents('php://input'), true)['reaction'];

    // Check if the user already liked the post
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$userId, $postId]);
    $existReaction = $stmt->fetch();

    if ($stmt->rowCount() === 0) {
        // Insert like
        $stmt1 = $pdo->prepare("INSERT INTO likes (user_id, post_id,like_dislike) VALUES (?, ?, ?)");
        $stmt1->execute([$userId, $postId, -1]);
    } else {
        if($existReaction['like_dislike'] == $reaction || $existReaction['like_dislike'] == 1){
            // Remove like
            $stmt1 = $pdo->prepare("UPDATE likes SET like_dislike = 0 WHERE user_id = ? AND post_id = ?");
            $stmt1->execute([$userId, $postId]);
        }
        else{
            $stmt1 = $pdo->prepare("UPDATE likes SET like_dislike=? WHERE user_id = ? AND post_id = ?");
            $stmt1->execute([$reaction, $userId, $postId]);
        }
        
        
    }

    // Get updated like count
    $stmt2 = $pdo->prepare("SELECT COUNT(*) as dislikeCount FROM likes WHERE post_id = ? AND like_dislike = -1");
    $stmt2->execute([$postId]);
    $dislikeCount = $stmt2->fetch()['dislikeCount'];

    echo json_encode(['success' => true, 'dislikeCount' => $dislikeCount]);
}
?>