<?php
session_start();
include('../includes/connection.txt');
$_SESSION['user_id']=1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitize($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    try {
        $pdo->beginTransaction();

        // Insert into `job_profile_curr`
        $stmt = $pdo->prepare("INSERT INTO job_profile_curr (user_id, job_title, company_name, industry, work_experience, skills, projects) 
                               VALUES (:user_id, :job_title, :company_name, :industry, :work_experience, :skills, :projects)");
        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':job_title' => $_SESSION['job_title'],
            ':company_name' => $_SESSION['company_name'],
            ':industry' => $_SESSION['industry'],
            ':work_experience' => $_SESSION['work_experience'],
            ':skills' => $_SESSION['skills'],
            ':projects' => $_SESSION['projects']
        ]);

        // Insert Past Companies
        if (!empty($_SESSION['past_companies'])) {
            $stmt = $pdo->prepare("INSERT INTO past_companies (user_id, company_name, role1, experience) 
                                   VALUES (:user_id, :company_name, :role, :experience)");
            foreach ($_SESSION['past_companies'] as $company) {
                $stmt->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':company_name' => $company['company_name'],
                    ':role' => $company['role'],
                    ':experience' => $company['experience']
                ]);
            }
        }

        $pdo->commit();

        // Clear session for this step
        unset($_SESSION['job_title'], $_SESSION['company_name'], $_SESSION['industry'], $_SESSION['work_experience'], $_SESSION['skills'], $_SESSION['projects'], $_SESSION['past_companies']);

        header("Location: contact_info.html"); // Move to next step
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error inserting data: " . $e->getMessage());
    }
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

        <a href="job_details.html"><button type="button">Edit</button></a>
        <form method="POST">
            <button type="submit">Confirm & Next</button>
        </form>
    </div>
</body>
</html>
