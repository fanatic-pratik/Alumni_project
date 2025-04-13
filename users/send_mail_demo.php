<?php
session_start();
include("../includes/connection.txt");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$err = [];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['t1']);
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $err[] = "Invalid email format.";
    } else {
        $sql = $pdo->prepare("SELECT user_id FROM users WHERE user_email = :u_mail");
        $sql->bindParam(":u_mail", $email, PDO::PARAM_STR);
        $sql->execute();
        $user = $sql->fetch();

        if($user) {
            // Generate random 4-digit OTP
            $otp = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            
            // Store OTP and expiration time (5 minutes from now)
            $_SESSION["otp"] = $otp;
            $_SESSION['otp_expiration'] = time() + 300; // 300 seconds = 5 minutes
            $_SESSION['reset_email'] = $email;

            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'gaikwad.ritu008@gmail.com'; // sender                 
                $mail->Password   = 'jowb ubxn lkyv host';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
                $mail->Port       = 587;                                    
                
                // Recipients
                $mail->setFrom('gaikwad.ritu008@gmail.com', 'Ritu Gaikwad');
                $mail->addAddress($email); // receiver    
                $mail->addReplyTo('gaikwad.ritu008@gmail.com', 'Ritu Gaikwad');
                
                // Content
                $mail->isHTML(true);                                 
                $mail->Subject = 'Password Reset OTP';
                $mail->Body    = 'Your password reset OTP is: <b>'. $otp .'</b><br><br>'
                               . 'This OTP is valid for 5 minutes.';
                $mail->AltBody = 'Your OTP is: '. $otp .' (valid for 5 minutes)';
                
                $mail->send();
                header("Location: reset_pass.php");
                exit();
                
            } catch (Exception $e) {
                $err[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                // Clear session if email fails
                
            } 
        } else {
            $err[] = "Email not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request OTP</title>
    <link rel="stylesheet" href="style/send_mail.css">
</head>
<body>
    <?php if(!empty($err)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($err as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <h1>Forgot Password</h1>
    <form method="POST" name="form1" action="">
        <label for="t1">Enter Your Email ID: </label>
        <input type="text" name="t1" id="t1" required><br>
        <input type="submit" name="btn1" value="Request OTP">
    </form>
</body>
</html>