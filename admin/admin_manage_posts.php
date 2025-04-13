
<?php
session_start();
$user_id = $_SESSION['user_id'];
echo $user_id;
$role = $_SESSION['role'];
echo $role;
include('../includes/connection.txt');

// Optional: check if admin is logged in
if (!isset($user_id) || $role !== 'admin') {
    die("Access denied. Admins only.");
}


// Approve or reject action
if (isset($_GET['action']) && isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $action = $_GET['action'];

    $status = $action === 'approve' ? 'approved' : 'rejected';
    $stmt = $pdo->prepare("UPDATE posts SET status = ? WHERE post_id = ?");
    $stmt->execute([$status, $post_id]);
    header("Location: admin_manage_posts.php?status=$status");
    exit;
}

// Handle Filter
$statusFilter = $_GET['status'] ?? '';

if ($statusFilter === '') {
    // No filter applied — show all posts
    $stmt = $pdo->query("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.user_id ORDER BY p.created_at DESC");
} else {
    $allowedFilters = ['pending', 'approved', 'rejected'];
    if (!in_array($statusFilter, $allowedFilters)) {
        $statusFilter = 'pending'; // fallback
    }

    $stmt = $pdo->prepare("SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.user_id WHERE p.status = ? ORDER BY p.created_at DESC");
    $stmt->execute([$statusFilter]);
}
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
</head>
<body>
<h2>Manage Posts</h2>

<form method="get" style="margin-bottom: 20px;">
    <label for="status">Filter by Status:</label>
    <select name="status" id="status" onchange="this.form.submit()">
    <option value="" <?= (!isset($_GET['status']) || $_GET['status'] === '') ? 'selected' : '' ?>>All</option>
        <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="approved" <?= $statusFilter === 'approved' ? 'selected' : '' ?>>Approved</option>
        <option value="rejected" <?= $statusFilter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
    </select>
</form>

<?php if (count($posts) === 0): ?>
    <p>No <?= $statusFilter ?> posts found.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <strong>User:</strong> <?= htmlspecialchars($post['username']) ?><br>
            <strong>Title:</strong> <?= htmlspecialchars($post['title']) ?><br>
            <strong>Type:</strong> <?= $post['post_type'] ?><br>
            <strong>Content:</strong> <?= nl2br(htmlspecialchars($post['content'])) ?><br>
            <?php if ($post['post_type'] === 'image' && $post['media_path']): ?>
                <img src="../users/<?= $post['media_path'] ?>" style="max-width:200px;"><br>
            <?php endif; ?>

            <?php if ($statusFilter === 'pending'): ?>
                <a href="?action=approve&post_id=<?= $post['post_id'] ?>">✅ Approve</a> |
                <a href="?action=reject&post_id=<?= $post['post_id'] ?>">❌ Reject</a>
            <?php else: ?>
                <em>Status: <?= ucfirst($post['status']) ?></em>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>