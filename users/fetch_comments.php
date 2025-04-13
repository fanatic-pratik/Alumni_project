<?php
session_start();
include('../includes/connection.txt');
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$post_id = $_GET['post_id'];

// Recursive function to fetch nested replies
function fetchReplies($pdo, $parent_id, $margin = 20) {
    global $user_id, $role;
    $stmt = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.parent_comment_id = ? ORDER BY c.created_at ASC");
    $stmt->execute([$parent_id]);
    $replies = $stmt->fetchAll();

    $html = '';
    foreach ($replies as $reply) {
        $isOwnerOrAdmin = ($user_id == $reply['user_id'] || $role == 'admin');

        $html .= '
        <div style="margin-left: '.$margin.'px; border-left: 1px solid #ccc; padding-left: 10px; margin-top: 10px;">
            <strong>'.$reply['username'].'</strong>: '.nl2br(htmlspecialchars($reply['content'])).'<br>
            <small>'.$reply['created_at'].'</small><br>
            '.($isOwnerOrAdmin ? '<a href="delete_comments.php" onclick="deleteComment('.$reply['comment_id'].', '.$reply['post_id'].')">🗑️ Delete</a><br>' : '').'
            <form onsubmit="submitComment(event, '.$reply['post_id'].', '.$reply['comment_id'].')">
                <textarea id="reply-text-'.$reply['comment_id'].'" placeholder="Reply..." required></textarea>
                <button type="submit">Reply</button>
            </form>
            '.fetchReplies($pdo, $reply['comment_id'], $margin + 20).'
        </div>';
    }
    
    return $html;
}

    

// Fetch top-level comments
$stmt = $pdo->prepare("SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.post_id = ? AND c.parent_comment_id IS NULL ORDER BY c.created_at DESC");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll();

$html = '';
foreach ($comments as $comment) {
    $html .= '
    <div style="margin-top: 10px;">
        <strong>'.$comment['username'].'</strong>: '.nl2br(htmlspecialchars($comment['content'])).'<br>
        <small>'.$comment['created_at'].'</small><br>';

    $isOwnerOrAdmin = ($user_id == $comment['user_id'] || $role == 'admin');
    if ($isOwnerOrAdmin) {
        $html .= '<a href="#" onclick="deleteComment('.$comment['comment_id'].', '.$comment['post_id'].')">🗑️ Delete</a><br>';
    }

    $html .= '<form onsubmit="submitComment(event, '.$comment['post_id'].', '.$comment['comment_id'].')">
            <textarea id="reply-text-'.$comment['comment_id'].'" placeholder="Reply..." required></textarea>
            <button type="submit">Reply</button>
        </form>
        '.fetchReplies($pdo, $comment['comment_id'], 20).'
    </div>';
}



echo $html;
?>