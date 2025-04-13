<?php
include('../includes/connection.txt');

$status = $_POST['status'] ?? '';

// Base SQL
$sql = "SELECT t.*, u.username 
        FROM testimonials t 
        JOIN users u ON t.user_id = u.user_id";

// Filter by status if provided
if (!empty($status)) {
    $sql .= " WHERE t.status = :status ORDER BY t.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['status' => $status]);
} else {
    $sql .= " ORDER BY t.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Output testimonials
if (count($testimonials) > 0) {
    foreach ($testimonials as $testimonial) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin:10px 0;'>";

        echo "<strong>User:</strong> " . htmlspecialchars($testimonial['username']) . "<br>";
        echo "<strong>Status:</strong> " . htmlspecialchars($testimonial['status']) . "<br>";
        echo "<p>" . nl2br(htmlspecialchars($testimonial['message'])) . "</p>";
        echo "<p>Submitted on: " . date("d M Y, h:i A", strtotime($testimonial['created_at'])) . "</p>";


        if (!empty($testimonial['image_url'])) {
            echo "<img src='../users/" . htmlspecialchars($testimonial['image_url']) . "' style='max-width:150px;'><br>";
        }

        if ($testimonial['status'] === 'pending') {
            echo "<button class='approveBtn' data-id='" . $testimonial['test_id'] . "'>✅ Approve</button> ";
            echo "<button class='rejectBtn' data-id='" . $testimonial['test_id'] . "'>❌ Reject</button>";
        }

        echo "</div>";
    }
} else {
    echo "<p>No testimonials found for this filter.</p>";
}
?>
