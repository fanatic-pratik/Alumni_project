<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    $f_name = sanitize($_POST['full_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $bio = sanitize($_POST['bio']);
    $grad_yr = filter_var($_POST['graduation_year'], FILTER_VALIDATE_INT);
    $course_degree = sanitize($_POST['course']);
    $specialization = sanitize($_POST['specialization']);
    $u_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $profile_pic_path = $_POST['profile_picture'];

    $sql="select * from user_info1 where user_id=1";
    $result= $pdo->query($sql);
    $rs = $result->fetch();
    echo $rs[2];
    if($rs){
        $stmt4 = $pdo->prepare("UPDATE user_info1 SET  full_name=:fname, dob=:dob, gender=:gen,profile_pic_name=:pfp_name, profile_pic_path=:pfp_path, bio=:bio,graduation_year=:grad_yr,course_degree=:course_degree,specialization=:specialization,u_email=:email WHERE user_id=1");
    // $stmt4->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
    $stmt4->bindParam(":fname", $f_name,PDO::PARAM_STR);
    $stmt4->bindParam(":dob", $dob,PDO::PARAM_STR);
    $stmt4->bindParam(":gen", $_SESSION['gender'],PDO::PARAM_STR);
    $stmt1->bindParam(":pfp_name", $_SESSION['profile_pic_name'], PDO::PARAM_STR);
    $stmt4->bindParam(":pfp_path",$_SESSION['profile_pic_path'],PDO::PARAM_STR);
    $stmt4->bindParam(":bio",$bio,PDO::PARAM_STR);
    $stmt4->bindParam(":grad_yr",$grad_yr,PDO::PARAM_STR);
    $stmt4->bindParam(":course_degree",$course_degree,PDO::PARAM_STR);
    $stmt4->bindParam(":specialization",$specialization,PDO::PARAM_STR);
    $stmt4->bindParam(":email",$u_email,PDO::PARAM_STR);

    if ($stmt4->execute()) {
        session_destroy();
        header('location:job_details.html');
    } else {
        echo "Error: " . $stmt4->error;
    }
    } else {
// Insert user into database
$stmt1 = $pdo->prepare("INSERT INTO user_info1 (full_name,dob, gender,profile_pic_name,profile_pic_path,bio, graduation_year, course_degree, specialization,u_email) VALUES (:full_name, :dob, :gender,:prof_pic_name,:prof_pic_path,:bio,:grad_yr,:course,:specialization,:mail)");
$stmt1->bindParam(":full_name", $f_name, PDO::PARAM_STR);
$stmt1->bindParam(":dob", $dob, PDO::PARAM_STR);
$stmt1->bindParam(":gender", $_SESSION['gender'], PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_name", $_SESSION['profile_pic_name'], PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_path", $_SESSION['profile_pic_path'], PDO::PARAM_STR);
$stmt1->bindParam(":bio", $bio, PDO::PARAM_STR);
$stmt1->bindParam(":grad_yr", $grad_yr, PDO::PARAM_INT);
$stmt1->bindParam(":course", $course_degree, PDO::PARAM_STR);
$stmt1->bindParam(":specialization",$specialization, PDO::PARAM_STR);
$stmt1->bindParam(":mail", $u_email, PDO::PARAM_STR);
if ($stmt1->execute()) {
    session_destroy();
    header('location:academic.php');
} else {
    echo "Error: " . $stmt1->error;
}
}
}
?>
