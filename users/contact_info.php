<?php
session_start();
include('../includes/connection.txt');
$sql="select * from contact_information where user_id=1";
$result= $pdo->query($sql);
$rs = $result->fetch();
if($rs){
    echo "hello";
    $phone = $rs[2];
    $linkedin = $rs[3];
    $github = $rs[4];
    $portfolio = $rs[5];

}else{
    echo "hello";
    $phone = "";
    $linkedin = "";
    $github = "";
    $portfolio = "";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3: Contact Information</title>
    <style>
        .progress { width: 100%; background-color: #e0e0e0; height: 20px; border-radius: 5px; overflow: hidden; margin-bottom: 20px; }
        .progress-bar { height: 100%; width: 100%; background-color: #4caf50; color: white; text-align: center; line-height: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Step 3: Contact Information</h2>
        <div class="progress"><div class="progress-bar">100%</div></div>

        <form action="contact_info_pre.php" method="POST">
            <label for="phone_number">Phone:</label>
            <input type="text" id="phone_number" name="phone_number" placeholder="Phone Number" maxlength="10" value="<?php echo $phone; ?>" required>
            <br>
            <label for="linkedin">LinkedIn:</label>
            <input type="url" id="linkedin" name="linkedin" placeholder="LinkedIn Profile" value="<?php echo $linkedin; ?>">
            <br>
            <label for="github">Github:</label>
            <input type="url" id="github" name="github" placeholder="GitHub Profile" value="<?php echo $github; ?>">
            <br>
            <label for="portfolio">Portfolio:</label>
            <input type="url" id="portfolio" name="portfolio" placeholder="Portfolio Website" value="<?php echo $portfolio; ?>">
            <br>

            <label>Profile Visibility:</label>
            <label><input type="radio" name="profile_visibility" value="Public" required> Public</label>
            <label><input type="radio" name="profile_visibility" value="Private"> Private</label>
            <br>
            <label>Contact Visibility:</label>
            <label><input type="radio" name="contact_visibility" value="Visible" required>Visible</label>
            <label><input type="radio" name="contact_visibility" value="Only Admins">Only Admins</label>
            <label><input type="radio" name="contact_visibility" value="Hidden">Hidden</label>
            <br>
            <a href="job_details.html"><button type="button">Previous</button></a>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
