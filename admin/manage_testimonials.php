<?php
session_start();
include('../includes/connection.txt');
$admin_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role !== 'admin') {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Testimonials</title>
    <style>
        .testimonial-box {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Manage Testimonials</h2>

    <!-- Filter Dropdown -->
    <select id="statusFilter">
        <option value="">All</option>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>

    <!-- Single unified testimonial container -->
    <div id="testimonialContainer"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    // Load testimonials based on filter
    function loadTestimonials(status = '') {
        $.ajax({
            url: 'load_testimonials.php',
            type: 'POST',
            data: { status: status },
            success: function(response) {
                $('#testimonialContainer').html(response);
            }
        });
    }

    // Initial load - all testimonials
    loadTestimonials();

    // Filter change
    $('#statusFilter').on('change', function () {
        const selectedStatus = $(this).val();
        loadTestimonials(selectedStatus);
    });

    // Approve / Reject button handler (delegated)
    $('#testimonialContainer').on('click', '.approveBtn, .rejectBtn', function () {
        const id = $(this).data('id');
        const status = $(this).hasClass('approveBtn') ? 'approved' : 'rejected';

        $.ajax({
            url: 'update_testimonial.php',
            method: 'POST',
            data: { id: id, status: status },
            success: function (response) {
                const currentStatus = $('#statusFilter').val();
                loadTestimonials(currentStatus); // Reload after action
            }
        });
    });
    </script>
</body>
</html>
