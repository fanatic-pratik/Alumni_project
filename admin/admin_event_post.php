<?php 
session_start();
$user_id = $_SESSION['user_id'];
echo $user_id;
$role = $_SESSION['role'];
echo $role;
include('../includes/connection.txt');

if (!isset($user_id) || $role !== 'admin') {
    die("Access denied. Admins only.");
}

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $created_by = $user_id;
    $imagePath = null;

    // Check if file is uploaded and error is 0
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
        $file = $_FILES['event_image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (!in_array($file['type'], $allowedTypes)) {
            die("Only JPG, PNG, and GIF files are allowed.");
        }

        $uploadDir = 'uploads_admin/events/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $uniqueFileName = uniqid() . '_' . basename($file['name']);
        $uploadPath = $uploadDir . $uniqueFileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $imagePath = $uploadPath;
        } else {
            die("Image upload failed.");
        }
    }
    $sql = "INSERT INTO events (event_name, event_description, event_date, event_time, location, image_url, created_by_Admin) 
            VALUES (:title, :description, :event_date, :event_time, :location, :image_url, :created_by)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':event_date' => $event_date,
        ':event_time' => $event_time,
        ':location' => $location,
        ':image_url' => $imagePath,
        ':created_by' => $created_by
    ]);

    $message = "Event posted successfully!";
    header('location:view_events.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Event</title>
</head>
<body>
<h2>Post a New Event</h2>
    <?php if ($message): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="5" required></textarea><br><br>

        <label>Date:</label><br>
        <input type="date" name="event_date" required><br><br>

        <label>Time:</label><br>
        <input type="time" name="event_time"><br><br>

        <label>Location:</label><br>
        <input type="text" name="location" required><br><br>

        <label>Event Image (optional):</label><br>
        <input type="file" name="event_image" accept="image/*"><br><br>

        <input type="submit" value="Post Event">
    </form>

</body>
</html>