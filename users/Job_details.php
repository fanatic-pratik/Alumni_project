<?php
session_start();
include('../includes/connection.txt');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['job_title'] = $_POST['job_title'];
    $_SESSION['company_name'] = $_POST['company_name'];
    $_SESSION['industry'] = $_POST['industry'];
    $_SESSION['work_experience'] = $_POST['work_experience'];
    $_SESSION['skills'] = $_POST['skills'];
    $_SESSION['projects'] = $_POST['projects'];

    $_SESSION['past_companies'] = [];
    if (isset($_POST['past_company_name'])) {
        for ($i = 0; $i < count($_POST['past_company_name']); $i++) {
            $_SESSION['past_companies'][] = [
                'company_name' => $_POST['past_company_name'][$i],
                'role' => $_POST['past_role'][$i],
                'experience' => $_POST['past_experience'][$i]
            ];
        }
    }
    session_destroy();
    header("Location: job_details.html"); // Move to preview page
    exit();
}
?>
