<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['phone_number'] = $_POST['phone_number'];
    $_SESSION['linkedin'] = $_POST['linkedin'];
    $_SESSION['github'] = $_POST['github'];
    $_SESSION['portfolio'] = $_POST['portfolio'];
    $_SESSION['profile_visibility'] = $_POST['profile_visibility'];
    $_SESSION['contact_visibility'] = $_POST['contact_visibility'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Preview Contact Information</title>
</head>
<body>
    <h2>Preview Contact Information</h2>
    <p><strong>Phone Number:</strong> <?php echo $_SESSION['phone_number'] ?></p>
    <p><strong>LinkedIn:</strong> <?php echo $_SESSION['linkedin'] ?></p>
    <p><strong>GitHub:</strong> <?php echo $_SESSION['github'] ?></p>
    <p><strong>Portfolio:</strong> <?php echo $_SESSION['portfolio'] ?></p>
    <p><strong>Profile Visibility:</strong> <?php echo ucfirst($_SESSION['profile_visibility']) ?></p>
    <p><strong>Contact Visibility:</strong> <?php echo ucfirst($_SESSION['contact_visibility']) ?></p>

    <form action="contact_info_submit.php" method="POST">
        <button type="submit">Confirm & Submit</button>
    </form>
    <a href="contact_info.html"><button type="button">Edit</button></a>
</body>
</html>
