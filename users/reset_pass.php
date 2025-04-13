<?php
session_start();
include("../includes/connection.txt");
// echo $_SESSION['reset_email'];
// $reset_email = $_SESSION['reset_email'];
// if(!isset($reset_email)){
//     header("location:login.php");
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_entered = $_POST['enter_OTP'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $otp = $_SESSION['otp'];
    echo $otp;
    $otpExpiration =  $_SESSION['otp_expiration'];

    if ($otp == $otp_entered) {
        $email = $_SESSION['reset_email'];
        $sql = $pdo->prepare("Update users set user_pass= :password where user_email=:mail");
        $sql->bindParam(":password", $new_pass);
        $sql->bindParam(":mail", $email);

        if ($sql->execute()) {
            echo "Password updated successfully";
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiration']);
            unset($_SESSION['reset_email']);
            header("location:login.php");
        } else {
            echo "Password not updated!";
        }
    } else {
        echo "Invalid OTP";

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/reset_pass.css">
</head>

<body>
    <h1>Reset Password</h1>
    <form name="form1" method="post" action="">
        <label for="enter_OTP">Enter OTP: </label>
        <input type="text" name="enter_OTP" id="enter_OTP" required><br>
        <label for="new_pass">Enter New Password: </label>
        <input type="text" name="new_pass" id="new_pass" required><br>
        <input type=submit value="Reset password">
    </form>

</body>

</html>