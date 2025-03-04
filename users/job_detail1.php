<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
if(isset($_POST['submit'])){
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    $job = sanitize($_POST['job_title']);
    $company1 = sanitize($_POST['company_name']);
    $industry = $_POST['industry'];
    $work_exp = sanitize($_POST['work_experience']);
    $skills = sanitize($_POST['skills']);
    $projects = sanitize($_POST['projects']);

    $stmt1 = $pdo->prepare("INSERT INTO job_profile_curr (user_id, job_title, company_name, industry, work_experience, skills, projects) 
                               VALUES (:user_id, :job_title, :company_name, :industry, :work_experience, :skills, :projects)");
        $stmt1->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt1->bindParam(":job_title", $job, PDO::PARAM_STR);
        $stmt1->bindParam(":company_name", $company1, PDO::PARAM_STR);
        $stmt1->bindParam(":industry", $industry, PDO::PARAM_STR);
        $stmt1->bindParam(":work_experience", $work_exp, PDO::PARAM_INT);
        $stmt1->bindParam(":skills", $skills, PDO::PARAM_STR);
        $stmt1->bindParam(":projects", $projects, PDO::PARAM_STR);
        
        if ($stmt1->execute()) {
        session_destroy();
        header('location:job_details1.php');
            //echo "successful";
        } else {
            echo "Error: " . $stmt1->error;
        }

        // if (!empty($_SESSION['past_companies'])) {
        //     $stmt = $pdo->prepare("INSERT INTO past_companies (user_id, company_name, role1, experience) 
        //                            VALUES (:user_id, :company_name, :role1, :experience)");
        //     foreach ($_SESSION['past_companies'] as $company) {
        //         $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        // $stmt->bindParam(":company_name", $company['company_name'], PDO::PARAM_STR);
        // $stmt->bindParam(":role1", $company['role'], PDO::PARAM_STR);
        // $stmt->bindParam(":experience", $company['experience'], PDO::PARAM_INT);
        
        // if ($stmt->execute()) {
        //     // session_destroy();
        //     // header('location:contact_info.php');
        //     echo "successful";
        // } else {
        //     echo "Error: " . $stmt->error;
        // }
        //     }
        // }
        // session_destroy();
        // header('location:job_details1.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="job_title" placeholder="Job Title" required>
    <input type="text" name="company_name" placeholder="Company Name" required>
    <input type="text" name="industry" placeholder="Industry" required>
    <input type="number" name="work_experience" placeholder="Years of Experience" required min="0">
    <textarea name="skills" placeholder="Skills"></textarea>
    <textarea name="projects" placeholder="Projects"></textarea>

    <input type="submit" name="submit" value="Save" />
</form> 
</body>
</html>


