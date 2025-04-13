<?php
session_start();
include('../includes/connection.txt'); // Include database connection
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error = "Both fields are required.";
    } else {
        // Prepare the SQL statement using PDO
        $stmt = $pdo->prepare("SELECT user_id, user_pass, profile_status,role FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        
        // Fetch user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['user_pass'])) {
                $_SESSION["user_id"] = $user['user_id'];
                $_SESSION["username"] = $username;
                $_SESSION['role'] = $user['role'];

                if($user['role'] === 'admin'){
                    header("location:../admin/admin_dashboard.php");
                }
                elseif($user['profile_status'] == 1){
                    header('location:home.php');
                }else{
                    header("location:academic.php");
                }
                // echo $_SESSION['user_id'];
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "User not found. Please register first.";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Login</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        function togglePassword() {
            var pass = document.getElementById("password");
            var toggleIcon = document.getElementById("toggleIcon");
            if (pass.type === "password") {
                pass.type = "text";
                toggleIcon.innerText = "🙈";
            } else {
                pass.type = "password";
                toggleIcon.innerText = "👁";
            }
        }
    </script>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.login-container {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 300px;
}

input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.password-container {
    display: flex;
    align-items: center;
}

.password-container input {
    flex: 1;
}

.password-container span {
    cursor: pointer;
    margin-left: 5px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.error {
    color: red;
    font-size: 14px;
}

    </style>

</head>
<body>
    <div class="login-container">
        <h2>Alumni Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form action="" method="POST" onsubmit="return validateForm()">
            <label>Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label>Password:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span id="toggleIcon" onclick="togglePassword()">👁</span>
            </div>

            <button type="submit">Login</button>
        </form>
        <p>Not registered? <a href="registration.php">Create an account</a></p>
        <a href="send_mail_demo.php">Forgot Password?</a>
    </div>

    <script>
        function validateForm() {
            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();

            if (username === "" || password === "") {
                alert("All fields are required.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
