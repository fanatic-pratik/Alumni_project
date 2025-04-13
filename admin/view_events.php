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

$stmt = $pdo->query("SELECT * FROM events ORDER BY event_date DESC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>All Events</title>
    <style>
        body {
            font-family: Arial;
            padding: 30px;
            background: #f4f4f4;
        }
        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        a.button {
            padding: 6px 12px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }
        a.delete {
            background: #dc3545;
        }
    </style>
</head>
<body>
    <h2>Manage Events</h2>
    <table>
        <tr>
            <th>Sr No.</th>
            <th>Title</th>
            <th>Date</th>
            <th>Location</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php $ctr = 1; ?>
        <?php foreach ($events as $event): ?>
        <tr>
            <?php
            $event_date = $event['event_date']; // e.g., '2025-04-06'
            $event_time = $event['event_time']; // e.g., '14:00:00'

            // Format date
            $formatted_date = date("F j, Y", strtotime($event_date)); // April 6, 2025

            // Format time
            $formatted_time = date("g:i A", strtotime($event_time)); // 2:00 PM
            ?>
            <td><?= $ctr++;?></td>
            <td><?= htmlspecialchars($event['event_name']) ?></td>
            <td><?= htmlspecialchars($formatted_date) ?></td>
            <td><?= htmlspecialchars($event['location'])?></td>
            <td><?= htmlspecialchars($formatted_time) ?></td>
            <td>
                <a class="button" href="edit_event.php?id=<?= $event['event_id'] ?>">Edit</a>
                <a class="button delete" href="delete_event.php?id=<?= $event['event_id'] ?>" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
