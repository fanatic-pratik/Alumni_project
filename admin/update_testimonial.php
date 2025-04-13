<?php
include('../includes/connection.txt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (in_array($status, ['approved', 'rejected'])) {
        $stmt = $pdo->prepare("UPDATE testimonials SET status = :status WHERE test_id = :id");
        $stmt->execute([
            'status' => $status,
            'id' => $id
        ]);
        echo "Status updated";
    } else {
        echo "Invalid status.";
    }
}
?>
