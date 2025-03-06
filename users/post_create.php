<?php
session_start();
include("../includes/connection.txt");

if(isset($_POST['submit'])){
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
    $post_type = sanitize($_POST['postType']);
    $title = sanitize($_POST['postTitle']);
    $content = sanitize($_POST['postContent']);

    $mediaPath = null;
    if ($post_type === 'image') {
        if (isset($_FILES['mediaFile'])) {
            $file = $_FILES['mediaFile'];
            $fileName = uniqid() . '_' . basename($file['name']); // Unique filename
            $uploadDir = 'uploads/posts/'; // Directory to store uploaded files
            $uploadPath = $uploadDir . $fileName;

            // Move uploaded file to the uploads directory
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                $mediaPath = $uploadPath;
            } else {
                die("File upload failed.");
            }
        }
    }
    $stmt1 = $pdo->prepare("INSERT INTO posts (user_id, post_type, title, content, media_path) VALUES (:user_id, :post_type, :title,:content,:mediaPath)");
    $stmt1->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt1->bindParam(":post_type", $post_type, PDO::PARAM_STR);
    $stmt1->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt1->bindParam(":content", $content, PDO::PARAM_STR);
    $stmt1->bindParam(":mediaPath", $mediaPath, PDO::PARAM_STR);

    if ($stmt1->execute()) {
        session_destroy();
        header('location:home.php');
    } else {
        echo "Error: " . $stmt1->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Create a New Post</h5>
        </div>
        <div class="card-body">
            <form id="postForm" action="" method="POST" enctype="multipart/form-data">
                <!-- Post Type Dropdown -->
                <div class="mb-3">
                    <label for="postType" class="form-label">Post Type</label>
                    <select class="form-select" id="postType" name="postType" required>
                        <option value="text">Text</option>
                        <option value="image">Image</option>
                        <!-- <option value="video">Video</option> -->
                    </select>
                </div>

                <!-- Title Input -->
                <div class="mb-3">
                    <label for="postTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Enter post title" required>
                </div>

                <!-- Content Textarea -->
                <div class="mb-3">
                    <label for="postContent" class="form-label">Content</label>
                    <textarea class="form-control" id="postContent" name="postContent" rows="5" placeholder="Write your post here..."></textarea>
                </div>

                <!-- File Upload (for Image/Video Posts) -->
                <div class="mb-3" id="mediaUploadField" style="display: none;">
                    <label for="mediaFile" class="form-label">Upload Media</label>
                    <input type="file" class="form-control" id="mediaFile" name="mediaFile" accept="image/*, video/*">
                </div>

                <!-- Submit Button -->
                <input type="submit" class="btn btn-primary" value="Create Post" name="submit"></input>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('postType').addEventListener('change', function () {
    const mediaUploadField = document.getElementById('mediaUploadField');
    if (this.value === 'image') {
        mediaUploadField.style.display = 'block';
    } else {
        mediaUploadField.style.display = 'none';
    }
});
</script>
</body>
</html>

