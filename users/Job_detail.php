<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    

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
            header('location:register.html');
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
            header('location:job_details.html');
        } else {
            echo "Error: " . $stmt->error;
        }
            }
        }

        

        // Clear session for this step
        // unset($_SESSION['job_title'], $_SESSION['company_name'], $_SESSION['industry'], $_SESSION['work_experience'], $_SESSION['skills'], $_SESSION['projects'], $_SESSION['past_companies']);

        header("Location: contact_info.html"); // Move to next step
        exit();
    

?>


