<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job_title'];
    $company1 = $_POST['company_name'];
    $industry = $_POST['industry'];
    $_SESSION['industry']=$_POST['industry'];
    $work_exp = $_POST['work_experience'];
    $skills = $_POST['skills'];
    $projects = $_POST['projects'];

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
    // session_destroy();
    // header("Location: job_details.html"); // Move to preview page
    // exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Details Preview</title>
</head>
<body>
    <div class="container">
        <h2>Preview Job Details</h2>
        <div class="progress"><div class="progress-bar" style="width: 66%;"></div></div>

        <p><strong>Job Title:</strong><?php echo htmlspecialchars($job_title); ?></p>
        <p><strong>Company Name:</strong> <?php echo htmlspecialchars($company1); ?></p>
        <p><strong>Industry:</strong> <?php echo htmlspecialchars($industry); ?></p>
        <p><strong>Work Experience:</strong> <?php echo htmlspecialchars($work_exp); ?> years</p>
        <p><strong>Skills:</strong> <?php echo nl2br(htmlspecialchars($skills)); ?></p>
        <p><strong>Projects:</strong> <?php echo nl2br(htmlspecialchars($projects)); ?></p>

        <h3>Past Companies:</h3>
        <?php if (!empty($_SESSION['past_companies'])): ?>
            <ul>
                <?php foreach ($_SESSION['past_companies'] as $company): ?>
                    <li><strong><?= htmlspecialchars($company['company_name']) ?></strong> - <?= htmlspecialchars($company['role']) ?> (<?= htmlspecialchars($company['experience']) ?> years)</li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No past companies added.</p>
        <?php endif; ?>

        <form action="Job_detail.php" method="POST">
        <input type="text" name="job_title" placeholder="Job Title" value="<?php echo $job_title; ?>" hidden>
            <input type="text" name="company_name" placeholder="Company Name" value="<?php echo $company1; ?>" hidden>
            <input type="text" name="industry" placeholder="Industry" value="<?php echo $_SESSION['industry']; ?>" hidden>
            <input type="number" name="work_experience" placeholder="Years of Experience" value="<?php echo $work_exp; ?>" hidden min="0">
            <textarea name="skills" placeholder="Skills" hidden><?php echo $skills; ?></textarea>
            <textarea name="projects" placeholder="Projects" hidden><?php echo $projects; ?></textarea>
            <button type="submit">Confirm & Next</button>
        </form>
        <form action="Job_details.php" method="POST">
            <button type="submit">Edit</button>
        </form>
    </div>
</body>
</html>
