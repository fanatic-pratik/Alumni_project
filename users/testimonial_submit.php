<?php
session_start();
include('../includes/connection.txt');
$user_id = $_SESSION['user_id'];
// AJAX form handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    if (!isset($user_id)) {
        echo "You must be logged in to submit a testimonial.";
        exit();
    }

    
    $message = trim($_POST['message']);
    $image_url = null;
    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!empty($_FILES['image']['name'])) {
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        echo "Only JPG, PNG, GIF, or WEBP images are allowed.";
        exit();
    }

    $targetDir = "uploads/testimonials/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $uniqueName = uniqid() . '_' . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $uniqueName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        $image_url = $targetFile;
    } else {
        echo "Failed to upload image.";
        exit();
    }
}

    if ($message != "") {
        $stmt = $pdo->prepare("INSERT INTO testimonials (user_id, message, image_url, created_at, status) VALUES (?, ?, ?, NOW(), 'pending')");
        $stmt->execute([$user_id, $message, $image_url]);
        echo "Testimonial submitted! Pending admin approval.";
    } else {
        echo "Please write something before submitting.";
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Testimonial</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h2>Submit a Testimonial</h2>

<form id="testimonialForm" enctype="multipart/form-data">
    <textarea name="message" placeholder="Your testimonial..." required style="width: 300px; height: 100px;"></textarea><br><br>
    <input type="file" name="image" accept="image/*" id="imageInput"><br><br>
    <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none; margin-top: 10px;"><br><br>

    <button type="submit">Submit</button>
</form>

<div id="responseMsg" style="margin-top: 10px;"></div>

<script>

     // Preview image before upload
     $("#imageInput").on("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#imagePreview").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#imagePreview").hide();
        }
    });

    //Submit form via AJAX
    $("#testimonialForm").on("submit", function(e){
        e.preventDefault();
        var formData = new FormData(this);
        formData.append("ajax", 1);

        $.ajax({
            url: "", // same page
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                $("#responseMsg").html(response);
                $("#testimonialForm")[0].reset();
                $("#imagePreview").hide();
            }
        });
    });
</script>

</body>
</html>
