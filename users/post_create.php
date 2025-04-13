<?php
session_start();
include('../includes/connection.txt');

$user_id = $_SESSION['user_id'];

// Handle AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    if (!$user_id) {
        echo "You must be logged in to post.";
        exit;
    }

    $post_type = $_POST['post_type'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']) ?? null;
    $media_path = null;

    // Handle image only if post_type is image
    if ($post_type === 'image' && !empty($_FILES['media']['name'])) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($_FILES['media']['type'], $allowedTypes)) {
            echo "Only JPG, PNG, GIF, or WEBP images are allowed.";
            exit;
        }

        $uploadDir = "uploads/posts/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uniqueName = uniqid() . '_' . basename($_FILES['media']['name']);
        $targetPath = $uploadDir . $uniqueName;

        if (!move_uploaded_file($_FILES['media']['tmp_name'], $targetPath)) {
            echo "Image upload failed.";
            exit;
        }

        $media_path = $targetPath;
    }

    // Basic keyword filtering (optional)
    $restricted = ['hate', 'abuse', 'violence'];
    foreach ($restricted as $word) {
        if (stripos($title, $word) !== false || stripos($content, $word) !== false) {
            echo "Post contains inappropriate content.";
            exit;
        }
    }

    // Save post
    $stmt = $pdo->prepare("INSERT INTO posts (user_id, post_type, title, content, media_path, created_at, status) 
                           VALUES (?, ?, ?, ?, ?, NOW(), 'pending')");
    $stmt->execute([$user_id, $post_type, $title, $content, $media_path]);

    echo "Post submitted successfully! Pending admin approval.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Post</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h3>Share Your Achievement or Update</h3>

<form id="postForm" enctype="multipart/form-data">
    <label>Post Type:</label>
    <select name="post_type" id="postType" required>
        <option value="text">Text</option>
        <option value="image">Image</option>
    </select><br><br>

    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" id="contentBox" style="width:300px; height:80px;"></textarea><br><br>

    <div id="imageSection" style="display:none;">
        <label>Select Image:</label><br>
        <input type="file" name="media" accept="image/*" id="imageInput"><br><br>

        <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none; margin-top: 10px;"><br><br>
    </div>

    <button type="submit">Submit</button>
</form>

<div id="responseMsg" style="margin-top:10px; font-weight:bold;"></div>

<script>
    // Toggle content/image section
    $("#postType").on("change", function () {
        const type = $(this).val();
        if (type === "image") {
            $("#imageSection").show();
            $("#contentBox").prop("required", false);
        } else {
            $("#imageSection").hide();
            $("#contentBox").prop("required", true);
            $("#imagePreview").hide(); // Hide preview when switching to text
        }
    });

    // Preview image before upload
    $("#imageInput").on("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            $("#imagePreview").hide();
        }
    });

    // AJAX Submit
    $("#postForm").on("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append("ajax", 1);

        $.ajax({
            url: "",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                $("#responseMsg").html(res);
                $("#postForm")[0].reset();
                $("#imageSection").hide();
                $("#imagePreview").hide();
            }
        });
    });
</script>

</body>
</html>
