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
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['event_title'];
    $description = $_POST['event_description'];
    $date = $_POST['event_date'];
    $location = $_POST['event_location'];
    $time = $_POST['event_time'];
    $imagePath = $event['image_url'];


    // Check if new image is uploaded
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
        $file = $_FILES['event_image'];
        $fileName = uniqid() . '_' . basename($file['name']);
        $uploadDir = 'uploads_admin/events/';
        $uploadPath = $uploadDir . $fileName;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old image if exists
            if (!empty($event['image_url']) && file_exists($event['image_url'])) {
                unlink($event['image_url']);
            }
            $imagePath = $uploadPath;
        }
    }

    $update = $pdo->prepare("UPDATE events SET event_name=?, event_description=?, event_date=?,event_time=?, location=?,image_url=? WHERE event_id=?");
    $update->execute([$title, $description, $date, $time, $location, $imagePath, $id]);

    header("Location: view_events.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h2>Edit Event</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="event_title" value="<?= htmlspecialchars($event['event_name']) ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="event_description" required><?= htmlspecialchars($event['event_description']) ?></textarea><br><br>

        <label>Date:</label><br>
        <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required><br><br>

        <label>Time:</label><br>
        <input type="time" name="event_time" value="<?= $event['event_time'] ?>" required><br><br>

        <label>Location:</label><br>
        <input type="text" name="event_location" value="<?= htmlspecialchars($event['location']) ?>" required><br><br>

        <label>Current Image:</label><br>
        <?php if (!empty($event['image_url'])): ?>
            <img src="<?= $event['image_url'] ?>" alt="Event Image"><br>
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>

        <label>Change Image:</label><br>
        <input type="file" name="event_image" accept="image/*"><br><br>

        <button type="submit">Update Event</button>
    </form>
</body>
</html>