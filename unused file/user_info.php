<?php
// session_start();
// include('../includes/connection.txt');
if (isset($_POST['submit'])){
    // Sanitize and validate input
    $fullName = htmlspecialchars(trim($_POST['fullName']), ENT_QUOTES, 'UTF-8');
    $dob = htmlspecialchars(trim($_POST['dob']), ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars(trim($_POST['gender']), ENT_QUOTES, 'UTF-8');
    $bio = htmlspecialchars(trim($_POST['bio']), ENT_QUOTES, 'UTF-8');
    $graduationYear = htmlspecialchars(trim($_POST['graduationYear']), ENT_QUOTES, 'UTF-8');
    $course = htmlspecialchars(trim($_POST['course']), ENT_QUOTES, 'UTF-8');
    $specialization = htmlspecialchars(trim($_POST['specialization']), ENT_QUOTES, 'UTF-8');

    // Validate inputs
    $errors = [];
    if (empty($fullName)) {
        $errors[] = "Full Name is required.";
    }
    if (empty($dob)) {
        $errors[] = "Date of Birth is required.";
    }
    if (empty($gender)) {
        $errors[] = "Gender is required.";
    }
    if (empty($bio)) {
        $errors[] = "Bio is required.";
    }
    if (empty($graduationYear) || $graduationYear < 1900 || $graduationYear > 2100) {
        $errors[] = "Please enter a valid Graduation Year.";
    }
    if (empty($course)) {
        $errors[] = "Course/Degree is required.";
    }
    if (empty($specialization)) {
        $errors[] = "Specialization is required.";
    }

    // Handle file upload
    $uploadFile = '';
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['profilePicture']['type'];

        if (in_array($fileType, $allowedTypes)) {
            $uploadDir = 'uploads/';
            // Create the uploads directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = basename($_FILES['profilePicture']['name']);
            $uploadFile = $uploadDir . uniqid() . '_' . $fileName; // Prevent file name conflicts

            // Move the uploaded file to the desired directory
            if (!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadFile)) {
                $errors[] = "Failed to upload profile picture.";
            }
        } else {
            $errors[] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
        }
    } else {
        $errors[] = "Profile picture is required.";
    }

    // Check for errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // If no errors, display success message
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Full Name: $fullName</p>";
        echo "<p>Date of Birth: $dob</p>";
        echo "<p>Gender: $gender</p>";
        echo "<p>Bio: $bio</p>";
        echo "<p>Graduation Year: $graduationYear</p>";
        echo "<p>Course/Degree: $course</p>";
        echo "<p>Specialization: $specialization</p>";
        echo "<p>Profile Picture: <img src='$uploadFile' alt='Profile Picture' style='max-width: 200px;'></p>";
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    
</head>
<body>
    <h2>User Registration Form</h2>
    <form id="registrationForm" name="register" action="" method="POST" enctype="multipart/form-data">
        <label for="fullName">Full Name:</label>
        <input type="text" id="fullName" name="fullName" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="">Select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br><br>

        <label for="profilePicture">Profile Picture:</label>
        <input type="file" id="profilePicture" name="profilePicture" accept="image/*" required><br><br>

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" rows="4" required></textarea><br><br>

        <label for="graduationYear">Graduation Year:</label>
        <input type="number" id="graduationYear" name="graduationYear" min="1900" max="2100" required><br><br>

        <label for="course">Course/Degree:</label>
        <input type="text" id="course" name="course" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required><br><br>

        <input type="submit" value="Register" id="submit" name="submit" >
    </form>
</body>
</html>
<script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
    const fullName = document.getElementById('fullName').value;
    const dob = document.getElementById('dob').value;
    const graduationYear = document.getElementById('graduationYear').value;

    // Basic validation
    if (fullName.trim() === '') {
        alert('Full Name is required.');
        event.preventDefault();
    }

    if (dob === '') {
        alert('Date of Birth is required.');
        event.preventDefault();
    }

    if (graduationYear < 1900 || graduationYear > 2100) {
        alert('Please enter a valid Graduation Year.');
        event.preventDefault();
    }
});
</script>