<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['phone_number'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $portfolio = $_POST['portfolio'];
    // $_SESSION['profile_visibility'] = $_POST['profile_visibility'];
    // $_SESSION['contact_visibility'] = $_POST['contact_visibility'];
    $sql="select * from contact_information where user_id=1";
    $result= $pdo->query($sql);
    $rs = $result->fetch();
    echo $rs[2];
    if($rs){
        $stmt4 = $pdo->prepare("UPDATE contact_information SET  phone_number=:phone, linkedin_profile=:linkedIn, github_profile=:git, portfolio=:portfolio, profile_visibility=:prof_visi,contact_visibility=:con_visi WHERE user_id=1");
    // $stmt4->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
    $stmt4->bindParam(":phone", $phone,PDO::PARAM_INT);
    $stmt4->bindParam(":linkedIn", $linkedin,PDO::PARAM_STR);
    $stmt4->bindParam(":git", $github,PDO::PARAM_STR);
    $stmt4->bindParam(":portfolio",$portfolio,PDO::PARAM_STR);
    $stmt4->bindValue(":prof_visi",$_SESSION['profile_visibility'],PDO::PARAM_STR);
    $stmt4->bindValue(":con_visi",$_SESSION['contact_visibility'],PDO::PARAM_STR);
    if ($stmt4->execute()) {
        session_destroy();
        header('location:contact_info.php');
    } else {
        echo "Error: " . $stmt4->error;
    }
    }else{
        $stmt4 = $pdo->prepare("INSERT INTO contact_information (user_id, phone_number, linkedin_profile, github_profile, portfolio, profile_visibility, contact_visibility) VALUES (:user_id,:phone,:linkedIn,:git,:portfolio,:prof_visi,:con_visi)");
    $stmt4->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
    $stmt4->bindParam(":phone", $phone,PDO::PARAM_INT);
    $stmt4->bindParam(":linkedIn", $linkedin,PDO::PARAM_STR);
    $stmt4->bindParam(":git", $github,PDO::PARAM_STR);
    $stmt4->bindParam(":portfolio",$portfolio,PDO::PARAM_STR);
    $stmt4->bindValue(":prof_visi",$_SESSION['profile_visibility'],PDO::PARAM_STR);
    $stmt4->bindValue(":con_visi",$_SESSION['contact_visibility'],PDO::PARAM_STR);
    if ($stmt4->execute()) {
        session_destroy();
        header('location:contact_info.php');
    } else {
        echo "Error: " . $stmt4->error;
    }
    }
}

    

    // echo "<h2>Contact Information Saved Successfully!</h2>";
    // session_destroy(); // Clear session after submission

?>
