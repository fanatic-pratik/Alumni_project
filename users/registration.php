<?php
include('../includes/connection.txt');
?>


<?php
  function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

// Function to validate PRN
function validatePRN($prn) {
    return preg_match("/^\d{10}$/", $prn); // Exactly 10 digits
}

// Function to validate Name
function validateName($name) {
    return preg_match("/^[a-zA-Z ]+$/", $name); // Only letters and spaces
}

// Function to validate Gmail
function validateGmail($gmail) {
    return filter_var($gmail, FILTER_VALIDATE_EMAIL) && strpos($gmail, '@gmail.com') !== false;
}

// Function to validate Batch Year
function validateBatchYear($batchYear) {
    return preg_match("/^\d{4}$/", $batchYear) && $batchYear >= 2000 && $batchYear <= date('Y');
}

// Function to validate Section
function validateSection($section) {
    return in_array($section, ['February', 'August']); // Must be 'A' or 'B'
}

// Function to validate Username
function validateUsername($username) {
    return preg_match("/^[a-zA-Z0-9]{5,15}$/", $username); // Alphanumeric, 5-15 characters
}

// Function to validate Password
function validatePassword($password) {
    return preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password); // At least 8 chars, one letter, one number
}

// if(isset($_POST['submit'])){
// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Sanitize and validate inputs
    echo "hello";
    $prn = sanitizeInput($_POST['prn']);
    $name = sanitizeInput($_POST['name']);
    $gmail = sanitizeInput($_POST['email']);
    $batchYear = sanitizeInput($_POST['batch_year']);
    $section = sanitizeInput($_POST['batch_section']);
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Validate each field
    $errors = [];

    if (!validatePRN($prn)) {
        $errors['prn'] = "Invalid PRN. It must be a 10-digit number.";
    }

    if (!validateName($name)) {
        $errors['name'] = "Invalid Name. Only letters and spaces are allowed.";
    }

    if (!validateGmail($gmail)) {
        $errors['email'] = "Invalid Gmail. It must be a valid Gmail address.";
    }

    if (!validateBatchYear($batchYear)) {
        $errors['batchyear'] = "Invalid Batch Year. It must be a 4-digit year between 2000 and the current year.";
    }

    if (!validateSection($section)) {
        $errors['section'] = "Invalid Section. It must be either 'A' or 'B'.";
    }

    if (!validateUsername($username)) {
        $errors['username'] = "Invalid Username. It must be alphanumeric and 5-15 characters long.";
    }

    if (!validatePassword($password)) {
        $errors['password'] = "Invalid Password. It must be at least 8 characters long and contain at least one letter and one number.";
    }

    
    // If there are no errors, process the data
    if (empty($errors)) {
      echo "Registration Successful!<br>";
      echo "PRN: " . $prn . "<br>";
      echo "Name: " . $name . "<br>";
      echo "Gmail: " . $gmail . "<br>";
      echo "Batch Year: " . $batchYear . "<br>";
      echo "Section: " . $section . "<br>";
      echo "Username: " . $username . "<br>";
      echo "Password: " . $password . "<br>";
    } else {
        // Display errors
        echo "<h2>Errors:</h2>";
        // foreach ($errors as $error) {
        //     echo "<p>" . $error . "</p>";
        // }
      }
    }
    //  else {
    //     echo "Invalid request method.";
    // }
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action=" " method="post">
  <label for="prn">PRN:</label>
  <input type="text" id="prn" name="prn" value="<?php echo isset($_POST['submit'])? $prn: ''; ?>"  required><br>
  <?php if(isset($errors['prn'])){ ?> <p ><?php echo $errors['prn']; ?></p><?php }; ?>

  <label for="name">Name:</label>
  <input type="text" id="name" name="name" value="<?php echo isset($_POST['submit'])? $name: ''; ?>" required><br>
  <?php if(isset($errors['name'])){ ?> <p><?php echo $errors['name']; ?></p> <?php }; ?>
  
  <label for="email">Gmail:</label>
  <input type="email" id="email" name="email" value="<?php echo isset($_POST['submit'])? $gmail: ''; ?>"  required><br>
  <?php if(isset($errors['email'])){ ?> <p><?php echo $errors['email']; ?></p> <?php }; ?>

  <label for="batch_year">Batch Year:</label>
  <input type="number" id="batch_year" name="batch_year" value="<?php echo isset($_POST['submit'])? $batchYear: ''; ?>"  min="2000" max="2100" required>
  <?php if(isset($errors['batchyear'])){ ?> <p><?php echo $errors['batchyear']; ?></p> <?php }; ?>

  <label for="batch_section">Batch Section:</label>
  <select id="batch_section" name="batch_section" value="<?php echo isset($_POST['submit'])? $section: ''; ?>"  required>
    <option value="">Select Section</option>
    <option value="February">February</option>
    <option value="August">August</option>
  </select><br>
  <?php if(isset($errors['section'])){ ?> <p><?php echo $errors['section']; ?></p> <?php }; ?><br>

  <label for="username">Create Username:</label>
  <input type="text" id="username" name="username" value="<?php echo isset($_POST['submit'])? $username: ''; ?>"  required><br><br>
  <?php if(isset($errors['username'])){ ?> <p><?php echo $errors['username']; ?></p><br><br> <?php }; ?>

  <label for="password">Create Password:</label>
  <input type="password" id="password" name="password" value="<?php echo isset($_POST['submit'])? $password: ''; ?>"  required><br>
  <?php if(isset($errors['password'])){ ?> <p><?php echo $errors['password']; ?></p><br><br> <?php }; ?>

  <button type="submit" name="submit">Register</button>
</form>
<div>

</div>

</body>
</html>
<?php

?>