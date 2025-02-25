<?php
session_start();
include('../includes/connection.txt');
// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['full_name'] = sanitize($_POST['full_name']);
    $_SESSION['dob'] = $_POST['dob'];
    $_SESSION['gender'] = $_POST['gender'];
    $_SESSION['bio'] = sanitize($_POST['bio']);
    $_SESSION['graduation_year'] = filter_var($_POST['graduation_year'], FILTER_VALIDATE_INT);
    $_SESSION['course'] = sanitize($_POST['course']);
    $_SESSION['specialization'] = sanitize($_POST['specialization']);
    $_SESSION['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    // $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Handle Profile Picture Upload Temporarily
//     $targetDir = "uploads/temp/";
//     if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);

//     $fileName = basename($_FILES["profile_picture"]["name"]);
//     $targetFilePath = $targetDir . uniqid() . "_" . $fileName;
//     $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

//     if (!in_array($fileType, ["jpg", "jpeg", "png"])) {
//         die("Only JPG, JPEG, and PNG files are allowed.");
//     }

//     if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
//         die("Error uploading file.");
//     }

//     

// Move file to permanent directory
if (($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
    //$user_id = $_SESSION["user_id"]; // Get logged-in user's ID
    $file_name = $_FILES["profile_picture"]["name"];
    $file_tmp = $_FILES["profile_picture"]["tmp_name"];
    $file_size = $_FILES["profile_picture"]["size"];
    $file_type = $_FILES["profile_picture"]["type"];

    // Set upload directory
    $upload_dir = "uploads/";
    // if (!is_dir($upload_dir)) {
    //     mkdir($upload_dir, 0777, true); // Create the directory if not exists
    // }

    // Generate a unique file name to avoid conflicts
    $unique_name = time() . "_" . $file_name;
    $file_path = $upload_dir . $unique_name;

    // Allowed file types (you can modify as needed)
    $allowed_types = ["image/jpeg", "image/png", "application/pdf"];

    if (in_array($file_type, $allowed_types)) {
        if ($file_size < 2 * 1024 * 1024) { // Limit file size to 5MB
            if (move_uploaded_file($file_tmp, $file_path)) {
                $file_name_new=$file_name;
                $file_path_new=$file_path;
       
                echo "File uploaded successfully.";
            } else {
                $errors['profile_picture']= "Error uploading file.";
            }
        } else {
            $errors['profile_picture']= "File size must be less than 5MB.";
        }
    } else {
        $errors['profile_picture']= "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
    }
    $_SESSION['profile_pic_name']=$file_name_new;
    $_SESSION['profile_pic_path'] = $file_path_new;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Registration</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; padding: 20px; }
        button { background: green; color: white; padding: 10px; width: 48%; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Preview Your Details</h2>
        <p><strong>Full Name:</strong> <?php echo $_SESSION['full_name']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $_SESSION['dob']; ?></p>
        <p><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></p>
        <p><strong>Bio:</strong> <?php echo $_SESSION['bio']; ?></p>
        <p><strong>Graduation Year:</strong> <?php echo $_SESSION['graduation_year']; ?></p>
        <p><strong>Course:</strong> <?php echo $_SESSION['course']; ?></p>
        <p><strong>Specialization:</strong> <?php echo $_SESSION['specialization']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Profile Picture:</strong></p>
        <img src="<?php echo $_SESSION['profile_pic_path']; ?>" width="100px" alt="Profile Picture">

        <form action="register.php" method="POST">
            <button type="submit">Confirm & Register</button>
        </form>
        <form action="register.html">
            <button type="submit">Edit</button>
        </form>
    </div>
</body>
</html>
