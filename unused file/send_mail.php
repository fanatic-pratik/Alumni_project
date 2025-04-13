<?php
session_start();
// $user_id = $_SESSION['user_id'];
// $username = $_SESSION['username'];
include("../includes/connection.txt");
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$err = [];
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email = trim($_POST['t1']);
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $err[] = "Invalid email format.";
    } else{
        $sql = $pdo->prepare("Select user_id from users where user_email = :u_mail");
        $sql->bindParam(":u_mail",$email,PDO::PARAM_STR);
        $sql->execute();
        $user=$sql->fetch();

        if($user){
            $otp = 1111;
            $_SESSION["otp"]=$otp;
            $_SESSION['reset_email']=$email;
            // echo $email;
    
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.gmail.com';                    
                $mail->SMTPAuth   = true;                                   
                $mail->Username   = 'gaikwad.ritu008@gmail.com';//sender                 
                $mail->Password   = 'jowb ubxn lkyv host';                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
                $mail->Port       = 587;                                    
                $mail->setFrom('gaikwad.ritu008@gmail.com', 'Ritu Gaikwad');
                $mail->addAddress($email); //reciever    
                $mail->addReplyTo('gaikwad.ritu008@gmail.com', 'Ritu Gaikwad');
                $mail->isHTML(true);                                 
                $mail->Subject = 'Password Reset OTP';
                $mail->Body    = 'The OTP for new password generation is'.'<b> '. $otp .' <b>';
                // $mail->AltBody = 'OTP valid only for 10 minutes.';
                $mail->send();
                echo 'Message has been sent';
                // echo $_SESSION['reset_email'];
                header("location:reset_pass.php");
                exit;
                
                } catch (Exception $e) {
                    $err[]= "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                } 
            }else{
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
    <?php if(!empty($err)):?>
        <div class="errors">
            <ul>
                <?php foreach ($err as $errors): ?>
                    <li><?php echo htmlspecialchars($errors); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    <h1>Forgot Password</h1>
    <form method="POST" name="form1" action="">
        <label for="t1">Enter Your Email ID: </label>
        <input type="text" name="t1" value="" id="t1" required><br>
        <input type="submit"  name="btn1" value="Request OTP">
</body>
</html>