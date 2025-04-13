<?php
include('../includes/connection.txt'); // path as per your project

$query = "SELECT * FROM events WHERE 1=1";
$params = [];

if (!empty($_GET['event_date'])) {
    $query .= " AND event_date = ?";
    $params[] = $_GET['event_date'];
}

if (!empty($_GET['category'])) {
    $query .= " AND category = ?";
    $params[] = $_GET['category'];
}

if (!empty($_GET['search'])) {
    $query .= " AND (event_name LIKE ? OR event_description LIKE ? OR category LIKE ?)";
    $search = '%' . $_GET['search'] . '%';
    $params[] = $search;
    $params[] = $search;
    $params[] = $search;
}

$query .= " ORDER BY event_date DESC, event_time DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($events) > 0) {
    foreach ($events as $event) {
        ?>
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
            <h3><?= htmlspecialchars($event['event_name']) ?></h3>
            <p><strong>Date:</strong> <?= date("F j, Y", strtotime($event['event_date'])) ?></p>
            <p><strong>Time:</strong> <?= date("g:i A", strtotime($event['event_time'])) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
            <p><?= nl2br(htmlspecialchars($event['event_description'])) ?></p>
            <?php if (!empty($event['image_url'])): ?>
                <img src="../admin/<?= $event['image_url'] ?>" alt="Event Image" style="max-width: 200px;">
            <?php endif; ?>
        </div>
        <?php
    }
} else {
    echo "<p>No events found matching your filters.</p>";
}
?>
