<?php
session_start();
include("../includes/connection.txt");

// Security check
if(!isset($_SESSION['reset_email'])) {
    header("location:login.php");
    exit();
}

// Handle OTP generation if not already set
if(!isset($_SESSION['otp'])) {
    // Generate 4-digit OTP
    $_SESSION['otp'] = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    // Set expiration (5 minutes from now)
    $_SESSION['otp_expiration'] = time() + 300;
    
    // In a real application, you would send this OTP via email/SMS
    // For demo purposes, we'll display it (remove in production)
    echo "<script>alert('Your OTP is: " . $_SESSION['otp'] . " (Demo only - in production this would be sent to your email)');</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_entered = $_POST['enter_OTP'];
    $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    
    // OTP validation
    if(!isset($_SESSION['otp'])) {
        $error = "OTP not generated or session expired";
    } 
    elseif(time() > $_SESSION['otp_expiration']) {
        $error = "OTP has expired. Please request a new one.";
        unset($_SESSION['otp']);
        unset($_SESSION['otp_expiration']);
    }
    elseif($otp_entered !== $_SESSION['otp']) {
        $error = "Invalid OTP";
    }
    else {
        // OTP is valid, proceed with password reset
        $email = $_SESSION['reset_email'];
        $sql = $pdo->prepare("UPDATE users SET user_pass = :password WHERE user_email = :mail");
        $sql->bindParam(":password", $new_pass);
        $sql->bindParam(":mail", $email);
        
        if($sql->execute()) {
            // Clear all session data
            unset($_SESSION['reset_email']);
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiration']);
            
            // Redirect with success message
            $_SESSION['reset_success'] = "Password updated successfully";
            header("location:login.php");
            exit();
        } else {
            $error = "Password not updated! Database error.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style/reset_pass.css">
</head>
<body>
    <h1>Reset Password</h1>
    
    <?php if(isset($error)): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <form name="form1" method="post" action="">
        <label for="enter_OTP">Enter OTP (Valid for 5 minutes): </label>
        <input type="text" name="enter_OTP" id="enter_OTP" required><br>
        
        <label for="new_pass">Enter New Password: </label>
        <input type="password" name="new_pass" id="new_pass" required><br>
        
        <input type="submit" value="Reset password">
    </form>

</body>
</html>