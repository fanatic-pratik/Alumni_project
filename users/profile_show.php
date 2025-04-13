<?php
session_start();
$user_id = $_SESSION['user_id'];
echo $user_id;
include("../includes/connection.txt");
try {
    $stmt1 = $pdo->prepare("SELECT full_name,dob,gender,bio,graduation_year,course_degree,specialization FROM user_info1 WHERE user_id = :id");
    $stmt1->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt1->execute();
    $user = $stmt1->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        die("User not found.");
    }

    $stmt2 = $pdo->prepare("SELECT job_title,company_name,industry,work_experience,skills,projects FROM job_profile_curr WHERE user_id = :id");
    $stmt2->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt2->execute();
    $user2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $stmt4 = $pdo->prepare("SELECT phone_number, linkedin_profile,github_profile,portfolio,profile_visibility,contact_visibility FROM contact_information WHERE user_id = :id");
    $stmt4->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt4->execute();
    $user4 = $stmt4->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Update profile settings if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $profile_visibility = isset($_POST['profile_visibility']) ? ($_POST['profile_visibility'] === "private" ? "private" : "public") : "public";
    $contact_visibility = in_array($_POST['contact_visibility'], ["public", "private", "admin"]) ? $_POST['contact_visibility'] : "private";

    try {
        $update_stmt = $pdo->prepare("UPDATE users SET profile_visibility = :profile_visibility, contact_visibility = :contact_visibility WHERE id = :id");
        $update_stmt->bindParam(':profile_visibility', $profile_visibility, PDO::PARAM_STR);
        $update_stmt->bindParam(':contact_visibility', $contact_visibility, PDO::PARAM_STR);
        $update_stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $update_stmt->execute();

        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit;
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <div class="profile-container">
        <h2>User Profile</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo $_SESSION['success'];
                                unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
        <p><strong>Graduation Year:</strong> <?php echo htmlspecialchars($user['graduation_year']); ?></p>
        <p><strong>Course/Degree:</strong> <?php echo htmlspecialchars($user['course_degree']); ?></p>
        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($user['specialization']); ?></p>

        <h2>Current Job Details</h2>
        <?php if ($user2) {
            foreach ($user2 as $u) {
        ?>
                <p><strong>Job Title:</strong> <?php echo htmlspecialchars($u['job_title']); ?></p>
                <p><strong>Company Name:</strong> <?php echo htmlspecialchars($u['company_name']); ?></p>
                <p><strong>Industry:</strong> <?php echo htmlspecialchars($u['industry']); ?></p>
                <p><strong>Work Experience:</strong> <?php echo htmlspecialchars($u['work_experience']); ?></p>
                <p><strong>Skills:</strong> <?php echo htmlspecialchars($u['skills']); ?></p>
                <p><strong>Projects:</strong> <?php echo htmlspecialchars($u['projects']); ?></p>
        <?php
            }
        } else {
            echo "No Job Details Found!!";
        } ?>


        <h2>Contact Information</h2>
        <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user4['phone_number']); ?></p>
        <p><strong>LinkedIn:</strong> <?php echo htmlspecialchars($user4['linkedin_profile']); ?></p>
        <p><strong>GitHub:</strong> <?php echo htmlspecialchars($user4['github_profile']); ?></p>
        <p><strong>Portfolio:</strong> <?php echo htmlspecialchars($user4['portfolio']); ?></p>

        <h2>Privacy</h2>
        <p><strong>Profile Visibility:</strong> <?php echo htmlspecialchars($user4['profile_visibility']); ?></p>
        <p><strong>Contact Visibility:</strong> <?php echo htmlspecialchars($user4['contact_visibility']); ?></p>

        </form>
        <a href="academic.php"><button>Edit Profile</button></a>
        <a href="home.php"><button>Main Page</button></a>
    </div>
</body>

</html>