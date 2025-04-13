<?php
include('../includes/connection.txt');

$sql = "SELECT t.message, t.image_url, u.username 
        FROM testimonials t 
        JOIN users u ON t.user_id = u.user_id 
        WHERE t.status = 'approved' 
        ORDER BY t.created_at DESC 
        LIMIT 10";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$testimonials = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($testimonials);
?>
