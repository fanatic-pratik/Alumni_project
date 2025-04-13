<?php
session_start();
include('../includes/connection.txt');
$admin_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$username = $_SESSION['username'];
if (!isset($admin_id) || $role !== 'admin') {
    die("Access denied. Admins only.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style/admin_dashboard.css">
</head>
<body>
<div class="dashboard">
        <h1>Welcome, Admin! <?php echo $username; ?></h1>

        <div class="card">
            <h2>Admin Profile</h2>
            <a href="../users/academic.php">➕ Edit Profile</a>
        </div>

        <div class="card">
            <h2>Add Posts</h2>
            <a href="add_posts.php">➕ Create a Post </a>
        </div>

        <div class="card">
            <h2>Manage Posts</h2>
            <a href="admin_manage_posts.php">📋 View all Posts </a>
        </div>

        <div class="card">
            <h2>Add Event</h2>
            <a href="admin_event_post.php">➕ Create New Event</a>
        </div>

        <div class="card">
            <h2>Manage Events</h2>
            <a href="view_events.php">📋 View All Events</a>
        </div>

        <div class="card">
            <h2>Add Testimonials</h2>
            <a href="add_testimonials.php">➕ Add Testimonials</a>
        </div>

        <div class="card">
            <h2>Manage Testimonials</h2>
            <a href="manage_testimonials.php">📋 View all Testimonials</a>
        </div>

        <div class="card">
            <h2>Logout</h2>
            <a href="../includes/logout.php">🚪 Logout</a>
        </div>
    </div>
</body>
</html>