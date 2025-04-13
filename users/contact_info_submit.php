<?php
session_start();  // Start the session at the beginning

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Database connection
include('../includes/connection.txt');
$user_id = $_SESSION['user_id'];

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve POST data
    $phone = $_POST['phone_number'];
    $linkedin = $_POST['linkedin'];
    $github = $_POST['github'];
    $portfolio = $_POST['portfolio'];
    
    // Check if data already exists in the contact_information table
    $sql = "SELECT * FROM contact_information WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $user_id]);
    $contactInfo = $stmt->fetch();

    // Check if data exists for the user
    if ($contactInfo) {
        // If data exists, update the contact information
        $updateStmt = $pdo->prepare("UPDATE contact_information SET 
            phone_number = :phone, 
            linkedin_profile = :linkedin, 
            github_profile = :github, 
            portfolio = :portfolio, 
            profile_visibility = :profile_visibility, 
            contact_visibility = :contact_visibility 
            WHERE user_id = :user_id");
        
        // Bind parameters
        $updateStmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $updateStmt->bindParam(":linkedin", $linkedin, PDO::PARAM_STR);
        $updateStmt->bindParam(":github", $github, PDO::PARAM_STR);
        $updateStmt->bindParam(":portfolio", $portfolio, PDO::PARAM_STR);
        $updateStmt->bindValue(":profile_visibility", $_SESSION['profile_visibility'], PDO::PARAM_STR);
        $updateStmt->bindValue(":contact_visibility", $_SESSION['contact_visibility'], PDO::PARAM_STR);
        $updateStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

        // Execute the query
        if ($updateStmt->execute()) {
            // Update the user's profile status to 1 (completed)
            $updateStatusStmt = $pdo->prepare("UPDATE users SET profile_status = 1 WHERE user_id = :user_id");
            $updateStatusStmt->execute(['user_id' => $user_id]);

            // Redirect to the home page after successful update
            header('Location: home.php');
            exit();
        } else {
            // If update fails, display the error
            echo "Error updating data: " . $updateStmt->errorInfo()[2];
        }

    } else {
        // If no data exists for the user, insert a new record
        $insertStmt = $pdo->prepare("INSERT INTO contact_information 
            (user_id, phone_number, linkedin_profile, github_profile, portfolio, profile_visibility, contact_visibility) 
            VALUES (:user_id, :phone, :linkedin, :github, :portfolio, :profile_visibility, :contact_visibility)");
        
        // Bind parameters
        $insertStmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $insertStmt->bindParam(":phone", $phone, PDO::PARAM_STR);
        $insertStmt->bindParam(":linkedin", $linkedin, PDO::PARAM_STR);
        $insertStmt->bindParam(":github", $github, PDO::PARAM_STR);
        $insertStmt->bindParam(":portfolio", $portfolio, PDO::PARAM_STR);
        $insertStmt->bindValue(":profile_visibility", $_SESSION['profile_visibility'], PDO::PARAM_STR);
        $insertStmt->bindValue(":contact_visibility", $_SESSION['contact_visibility'], PDO::PARAM_STR);

        // Execute the query
        if ($insertStmt->execute()) {
            // Update the user's profile status to 1 (completed)
            $updateStatusStmt = $pdo->prepare("UPDATE users SET profile_status = 1 WHERE user_id = :user_id");
            $updateStatusStmt->execute(['user_id' => $user_id]);

            // Redirect to the home page after successful insert
            header('Location: home.php');
            exit();
        } else {
            // If insert fails, display the error
            echo "Error inserting data: " . $insertStmt->errorInfo()[2];
        }
    }
}
?>
