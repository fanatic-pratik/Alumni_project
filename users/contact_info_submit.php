<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
try {
    $stmt4 = $pdo->prepare("INSERT INTO contact_information (user_id, phone_number, linkedin_profile, github_profile, portfolio, profile_visibility, contact_visibility) VALUES (:user_id,:phone,:linkedIn,:git,:portfolio,:prof_visi,:con_visi)");
    $stmt4->bindParam(":user_id",$_SESSION['user_id'],PDO::PARAM_INT);
    $stmt4->bindParam(":phone", $_SESSION['phone_number'],PDO::PARAM_INT);
    $stmt4->bindParam(":linkedIn", $_SESSION['linkedin'],PDO::PARAM_STR);
    $stmt4->bindParam(":git", $_SESSION['github'],PDO::PARAM_STR);
    $stmt4->bindParam(":portfolio",$_SESSION['portfolio'],PDO::PARAM_STR);
    $stmt4->bindValue(":prof_visi",$_SESSION['profile_visibility'],PDO::PARAM_STR);
    $stmt4->bindValue(":con_visi",$_SESSION['contact_visibility'],PDO::PARAM_STR);
    if ($stmt4->execute()) {
        session_destroy();
        header('location:job_details.html');
    } else {
        echo "Error: " . $stmt4->error;
    }

    // echo "<h2>Contact Information Saved Successfully!</h2>";
    // session_destroy(); // Clear session after submission
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
