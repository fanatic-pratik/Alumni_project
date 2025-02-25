<?php
session_start();
include('../includes/connection.txt');

// Insert user into database
$stmt1 = $pdo->prepare("INSERT INTO user_info1 (full_name,dob, gender,profile_pic_name,profile_pic_path,bio, graduation_year, course_degree, specialization,u_email) VALUES (:full_name, :dob, :gender,:prof_pic_name,:prof_pic_path,:bio,:grad_yr,:course,:specialization,:mail)");
$stmt1->bindParam(":full_name", $_SESSION['full_name'], PDO::PARAM_STR);
$stmt1->bindParam(":dob", $_SESSION['dob'], PDO::PARAM_STR);
$stmt1->bindParam(":gender", $_SESSION['gender'], PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_name", $_SESSION['profile_pic_name'], PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_path", $_SESSION['profile_pic_path'], PDO::PARAM_STR);
$stmt1->bindParam(":bio", $_SESSION['bio'], PDO::PARAM_STR);
$stmt1->bindParam(":grad_yr", $_SESSION['graduation_year'], PDO::PARAM_INT);
$stmt1->bindParam(":course", $_SESSION['course'], PDO::PARAM_STR);
$stmt1->bindParam(":specialization",$_SESSION['specialization'], PDO::PARAM_STR);
$stmt1->bindParam(":mail", $_SESSION['email'], PDO::PARAM_STR);
if ($stmt1->execute()) {
    session_destroy();
    header('location:register.html');
} else {
    echo "Error: " . $stmt1->error;
}
?>
