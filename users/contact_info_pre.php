<?php
session_start();
include('../includes/connection.txt');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone_number'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $portfolio = $_POST['portfolio'];
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
    <p><strong>Phone Number:</strong> <?php echo $phone ?></p>
    <p><strong>LinkedIn:</strong> <?php echo $linkedin ?></p>
    <p><strong>GitHub:</strong> <?php echo $github ?></p>
    <p><strong>Portfolio:</strong> <?php echo $portfolio ?></p>
    <p><strong>Profile Visibility:</strong> <?php echo ucfirst($_SESSION['profile_visibility']) ?></p>
    <p><strong>Contact Visibility:</strong> <?php echo ucfirst($_SESSION['contact_visibility']) ?></p>

    <form action="contact_info_submit.php" method="POST">
    <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" maxlength="10" value="<?php echo $phone; ?>" hidden>
    <input type="url" id="linkedin" name="linkedin" placeholder="LinkedIn Profile" value="<?php echo $linkedin; ?>" hidden>
    <input type="url" id="github" name="github" placeholder="GitHub Profile" value="<?php echo $github; ?>" hidden>
    <input type="url" id="portfolio" name="portfolio" placeholder="Portfolio Website" value="<?php echo $portfolio; ?>" hidden>
        <button type="submit">Confirm & Submit</button>
    </form>
    <a href="contact_info.php"><button type="button">Edit</button></a>
</body>
</html>
