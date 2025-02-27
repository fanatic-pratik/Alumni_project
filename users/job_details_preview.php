<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
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

        <p><strong>Job Title:</strong> <?= htmlspecialchars($_SESSION['job_title']) ?></p>
        <p><strong>Company Name:</strong> <?= htmlspecialchars($_SESSION['company_name']) ?></p>
        <p><strong>Industry:</strong> <?= htmlspecialchars($_SESSION['industry']) ?></p>
        <p><strong>Work Experience:</strong> <?= htmlspecialchars($_SESSION['work_experience']) ?> years</p>
        <p><strong>Skills:</strong> <?= nl2br(htmlspecialchars($_SESSION['skills'])) ?></p>
        <p><strong>Projects:</strong> <?= nl2br(htmlspecialchars($_SESSION['projects'])) ?></p>

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
            <button type="submit">Confirm & Next</button>
        </form>
        <form action="Job_details.html" method="POST">
            <button type="submit">Edit</button>
        </form>
    </div>
</body>
</html>
