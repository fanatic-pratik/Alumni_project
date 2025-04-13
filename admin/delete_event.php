<?php
session_start();
$admin_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$username = $_SESSION['username'];
include('../includes/connection.txt');

if (!isset($admin_id) || $role !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM events WHERE event_id = ?");
    $stmt->execute([$id]);
}

header("Location: view_events.php");
exit();
?>