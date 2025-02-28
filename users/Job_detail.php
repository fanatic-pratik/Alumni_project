<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
$sql="select * from user_info1 where user_id=1";
    $result= $pdo->query($sql);
    $rs = $result->fetch();
    echo $rs[2];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    $job = sanitize($_POST['job_title']);
    $company1 = sanitize($_POST['company_name']);
    $industry = $_POST['industry'];
    $work_exp = sanitize($_POST['work_experience']);
    $skills = sanitize($_POST['skills']);
    $projects = sanitize($_POST['projects']);
    
    if($rs){
        $stmt1 = $pdo->prepare("UPDATE job_profile_curr SET  job_title=:job_title, company_name=:company_name, industry=:industry, work_experience=:work_experience, skills=:skills, projects=:projects WHERE user_id=:user_id");
        $stmt1->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt1->bindParam(":job_title", $job, PDO::PARAM_STR);
        $stmt1->bindParam(":company_name", $company1, PDO::PARAM_STR);
        $stmt1->bindParam(":industry", $_SESSION['industry'], PDO::PARAM_STR);
        $stmt1->bindParam(":work_experience", $work_exp, PDO::PARAM_INT);
        $stmt1->bindParam(":skills", $skills, PDO::PARAM_STR);
        $stmt1->bindParam(":projects", $projects, PDO::PARAM_STR);
        
        if ($stmt1->execute()) {
            // session_destroy();
            // header('location:contact_info.php');
        } else {
            echo "Error: " . $stmt1->error;
        }

        if(!empty($_SESSION['past_companies'])) {
            $stmt2 = $pdo->prepare("UPDATE past_companies SET company_name=:company_name, role1=:role1, experience=:experience where user_id=:user_id AND company_id=:com_id");
            foreach ($_SESSION['past_companies'] as $company) {
                $stmt2->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt2->bindParam(":company_name", $company['company_name'], PDO::PARAM_STR);
        $stmt2->bindParam(":role1", $company['role'], PDO::PARAM_STR);
        $stmt2->bindParam(":experience", $company['experience'], PDO::PARAM_INT);
        $stmt2->bindParam(":com_id", $company['company_id'], PDO::PARAM_INT);
        // $stmt2->execute();
        if ($stmt2->execute()) {
            //session_destroy();
            //header('location:contact_info.php');
        } else {
            echo "Error: " . $stmt2->error;
        }
            }
            session_destroy();
            header('location:contact_info.php');
        }
    } else {

        // Insert into `job_profile_curr`
        $stmt1 = $pdo->prepare("INSERT INTO job_profile_curr (user_id, job_title, company_name, industry, work_experience, skills, projects) 
                               VALUES (:user_id, :job_title, :company_name, :industry, :work_experience, :skills, :projects)");
        $stmt1->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt1->bindParam(":job_title", $_SESSION['job_title'], PDO::PARAM_STR);
        $stmt1->bindParam(":company_name", $_SESSION['company_name'], PDO::PARAM_STR);
        $stmt1->bindParam(":industry", $_SESSION['industry'], PDO::PARAM_STR);
        $stmt1->bindParam(":work_experience", $_SESSION['work_experience'], PDO::PARAM_INT);
        $stmt1->bindParam(":skills", $_SESSION['skills'], PDO::PARAM_STR);
        $stmt1->bindParam(":projects", $_SESSION['projects'], PDO::PARAM_STR);
        
        if ($stmt1->execute()) {
            session_destroy();
            header('location:contact_info.php');
        } else {
            echo "Error: " . $stmt1->error;
        }

        // Insert Past Companies
        if (!empty($_SESSION['past_companies'])) {
            $stmt = $pdo->prepare("INSERT INTO past_companies (user_id, company_name, role1, experience) 
                                   VALUES (:user_id, :company_name, :role1, :experience)");
            foreach ($_SESSION['past_companies'] as $company) {
                $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(":company_name", $company['company_name'], PDO::PARAM_STR);
        $stmt->bindParam(":role1", $company['role'], PDO::PARAM_STR);
        $stmt->bindParam(":experience", $company['experience'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            session_destroy();
            header('location:contact_info.php');
        } else {
            echo "Error: " . $stmt->error;
        }
            }
        }

        

        // Clear session for this step
        // unset($_SESSION['job_title'], $_SESSION['company_name'], $_SESSION['industry'], $_SESSION['work_experience'], $_SESSION['skills'], $_SESSION['projects'], $_SESSION['past_companies']);

        header("Location: contact_info.php"); // Move to next step
        exit();
    }
}
?>


