<?php
session_start();
include('../includes/connection.txt');
$user_id=$_SESSION['user_id'];
echo $user_id;
$jid=$_GET['id'];
$sql= "select * from job_profile_curr where job_id = $jid";
$result=$pdo->query($sql);
$rs=$result->fetch();

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

    $stmt1 = $pdo->prepare("UPDATE job_profile_curr SET job_title=:job_title, company_name=:company_name, industry=:industry, work_experience=:work_experience,
     skills=:skills, projects=:projects WHERE job_id=$jid");
    // $stmt1->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt1->bindParam(":job_title", $job, PDO::PARAM_STR);
        $stmt1->bindParam(":company_name", $company1, PDO::PARAM_STR);
        $stmt1->bindParam(":industry",$industry, PDO::PARAM_STR);
        $stmt1->bindParam(":work_experience", $work_exp, PDO::PARAM_INT);
        $stmt1->bindParam(":skills", $skills, PDO::PARAM_STR);
        $stmt1->bindParam(":projects", $projects, PDO::PARAM_STR);
        if ($stmt1->execute()) {
            header('location:job_details1.php');
        } else {
            echo "Error: " . $stmt1->error;
        }
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
    <input type="text" name="job_title" placeholder="Job Title" value="<?php echo $rs[2]; ?>" required>
    <input type="text" name="company_name" placeholder="Company Name" value="<?php echo $rs[3]; ?>" required>
    <input type="text" name="industry" placeholder="Industry" value="<?php echo $rs[4]; ?>" required>
    <input type="number" name="work_experience" placeholder="Years of Experience" value="<?php echo $rs[5]; ?>" required min="0">
    <textarea name="skills" placeholder="Skills"><?php echo $rs[6]; ?></textarea>
    <textarea name="projects" placeholder="Projects"><?php echo $rs[7]; ?></textarea>

    <input type="submit" name="submit" value="Save" />
</form> 
</body>
</html>