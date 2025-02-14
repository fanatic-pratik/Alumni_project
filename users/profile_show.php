<?php
session_start();
include("../includes/connection.txt");
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php"); // Redirect to login if not logged in
//     exit;
// }
// $user_id = $_SESSION['user_id'];
// Fetch user details
$user_id=1;
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
    $user2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    
    $stmt3 = $pdo->prepare("SELECT company_name,role1,experience FROM past_companies WHERE user_id = :id");
    $stmt3->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt3->execute();
    $user3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    
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
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($user['dob']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
        <p><strong>Graduation Year:</strong> <?php echo htmlspecialchars($user['graduation_year']); ?></p>
        <p><strong>Course/Degree:</strong> <?php echo htmlspecialchars($user['course_degree']); ?></p>
        <p><strong>Specialization:</strong> <?php echo htmlspecialchars($user['specialization']); ?></p>
       
        <h2>Current Job Details</h2>
        <p><strong>Job Title:</strong> <?php echo htmlspecialchars($user2['job_title']); ?></p>
        <p><strong>Company Name:</strong> <?php echo htmlspecialchars($user2['company_name']); ?></p>
        <p><strong>Industry:</strong> <?php echo htmlspecialchars($user2['industry']); ?></p>
        <p><strong>Work Experience:</strong> <?php echo htmlspecialchars($user2['work_experience']); ?></p>
        <p><strong>Skills:</strong> <?php echo htmlspecialchars($user2['skills']); ?></p>
        <p><strong>Projects:</strong> <?php echo htmlspecialchars($user2['projects']); ?></p>

        <h2>Past Companies</h2>
        <?php
        foreach($user3 as $user_3): ?>
        <p><strong>Company Name:</strong> <?php echo htmlspecialchars($user_3['company_name']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($user_3['role1']); ?></p>
        <p><strong>Experience:</strong> <?php echo htmlspecialchars($user_3['experience']); ?></p>
        <?php endforeach; ?>

        <h2>Contact Information</h2>
        <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user4['phone_number']); ?></p>
        <p><strong>LinkedIn:</strong> <?php echo htmlspecialchars($user4['linkedin_profile']); ?></p>
        <p><strong>GitHub:</strong> <?php echo htmlspecialchars($user4['github_profile']); ?></p>
        <p><strong>Portfolio:</strong> <?php echo htmlspecialchars($user4['portfolio']); ?></p>

        <h2>Privacy</h2>
        <p><strong>Profile Visibility:</strong> <?php echo htmlspecialchars($user4['profile_visibility']); ?></p>
        <p><strong>Contact Visibility:</strong> <?php echo htmlspecialchars($user4['contact_visibility']); ?></p>



        <!-- <//?php if ($user4['profile_visibility'] === 'public' && $user4['contact_visibility'] === 'visible'): ?>
            <p><strong>Contact Number:</strong> 
                <//?php 
                    echo htmlspecialchars($user4['phone_number']); 
                ?>
            </p>
            <p><strong></strong> 
                <//?php echo ($user['contact_visibility'] === 'public' || ($_SESSION['role'] === 'admin' && $user['contact_visibility'] === 'admin')) ? htmlspecialchars($user['address']) : "Hidden"; ?>
            </p>
        <//?php else: ?>
            <p><em>This profile is private.</em></p>
        <//?php endif; ?> -->

        <!-- <h3>Update Profile Settings</h3>
        <form action="profile.php" method="POST">
            <label for="profile_visibility">Profile Visibility:</label>
            <select name="profile_visibility">
                <option value="public" <//?php echo $user['profile_visibility'] === 'public' ? 'selected' : ''; ?>>Public</option>
                <option value="private" <//?php echo $user['profile_visibility'] === 'private' ? 'selected' : ''; ?>>Private</option>
            </select>

            <label for="contact_visibility">Contact Visibility:</label>
            <select name="contact_visibility">
                <option value="public" <//?php echo $user['contact_visibility'] === 'public' ? 'selected' : ''; ?>>Public</option>
                <option value="private" <//?php echo $user['contact_visibility'] === 'private' ? 'selected' : ''; ?>>Private</option>
                <option value="admin" <//?php echo $user['contact_visibility'] === 'admin' ? 'selected' : ''; ?>>Admin Only</option>
            </select>

            <button type="submit">Save Changes</button> -->
        </form>
    </div>
</body>
</html>