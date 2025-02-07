<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_profiles";

// Connect to database
// $conn = new mysqli($servername, $username, $password, $dbname);
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

if(isset($_POST['submit'])){
// 🔴 Validate and Sanitize Input Function
function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 🛑 Validate and Sanitize Inputs
$name = clean_input($_POST['name']);
$dob = clean_input($_POST['dob']);
$gender = clean_input($_POST['gender']);
$bio = clean_input($_POST['bio']);

$graduation_year = filter_var($_POST['graduation_year'], FILTER_VALIDATE_INT);
$course = clean_input($_POST['course']);
$specialization = clean_input($_POST['specialization']);

$job_title = clean_input($_POST['job_titlecurr']);
$company = clean_input($_POST['company']);
$industry = clean_input($_POST['industry']);
$experience = filter_var($_POST['experience'], FILTER_VALIDATE_INT);
$skills = clean_input($_POST['skills']);
$projects = clean_input($_POST['current_projects']);

$phone = clean_input($_POST['phone']);
$linkedin = filter_var($_POST['linkedin'], FILTER_VALIDATE_URL);
$github = filter_var($_POST['github'], FILTER_VALIDATE_URL);
$blog = filter_var($_POST['website'], FILTER_VALIDATE_URL);


$errors= [];
// 🛑 Validate Image Upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($_FILES['profile_picture']['type'], $allowed_types) && $_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
        $errors['profile_picture']= "invalid file type or image size is more than 2mb";
    }
}

function validateName($name) {
    return preg_match("/^[a-zA-Z ]+$/", $name); // Only letters and spaces
}

// Function to validate Batch Year
function validateGraduationYear($graduation_year) {
    return preg_match("/^\d{4}$/", $graduation_year) && $graduation_year >= 2000 && $graduation_year <= date('Y');
}

function validateDOB($dob) {
    return preg_match("/^\d{4}$/", $dob) && $dob <= 2010 && $dob <= date('Y');
}

function validateBio($bio) {
    return preg_match("/^[\w\s,]+$/u", $bio); // Only letters and spaces and commas ,underscore
}

function validateCourse($course) {
    return preg_match("/^[\w\s,]+$/u", $course); // Only letters and spaces and commas ,underscore
}

function validateSpecialization($specialization) {
    return preg_match("/^[\w\s,]+$/u", $specialization); // Only letters and spaces and commas ,underscore
}

function validateJobtitle($job_title) {
    return preg_match("/^[\w\s,]+$/u", $job_title); // Only letters and spaces and commas ,underscore
}

function validateCompany($company) {
    return preg_match("/^[\w\s,]+$/u", $company); // Only letters and spaces and commas ,underscore
}

function validateBio($skills) {
    return preg_match("/^[\w\s,]+$/u", $skills); // Only letters and spaces and commas ,underscore
}

function validateProjects($projects) {
    return preg_match("/^[\w\s,]+$/u", $projects); // Only letters and spaces and commas ,underscore
}

function validatePhone($phone) {
    $phone = str_replace(' ', '', $phone);
    return preg_match("/^\+?\d{10,15}$/", $phone); // Only letters and spaces and commas ,underscore
}

// 🔴 Prepare SQL Statement to Prevent SQL Injection
// $stmt = $conn->prepare("INSERT INTO users (name, dob, gender, bio, graduation_year, course, specialization, phone, linkedin, github) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
// $stmt->bind_param("ssssisssss", $name, $dob, $gender, $bio, $graduation_year, $course, $specialization, $phone, $linkedin, $github);

// if ($stmt->execute()) {
//     echo "Profile updated successfully!";
// } else {
//     echo "Error: " . $stmt->error;
// }

// $stmt->close();
// $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Creation</title>
    <link rel="stylesheet" href="../style/profile_creation.css">
    
</head>
<body>

    <form action=" " method="POST" enctype="multipart/form-data">
        <h2>Personal Information</h2>
        <hr>

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob"><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture"><br><br>

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"></textarea><br><br>

        <h2>Academic Information</h2>
        <hr>
        <label for="graduation_year">Graduation Year:</label>
        <input type="number" id="graduation_year" name="graduation_year" required min=1990 max=2025><br><br>

        <label for="course">Course/Degree:</label>
        <input type="text" id="course" name="course" maxlength="20" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" maxlength="20"><br><br>

        <h2>Professional Information</h2>
        <hr>
        <label for="job_title_curr">Job Title:</label>
        <input type="text" id="job_title_curr" name="job_titlecurr"><br><br>

        <label for="company">Company Name:</label>
        <input type="text" id="company" name="company"><br><br>

        <label for="industry">Industry:</label>
        <select id="industry" name="industry">
            <option value="IT">IT</option>
            <option value="Healthcare">Healthcare</option>
            <option value="Finance">Finance</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="experience">Work Experience (Years):</label>
        <input type="number" id="experience" name="experience" min=0 max=30><br><br>

        <label for="skills">Skills:</label>
        <textarea id="skills" name="skills" maxlength="100"></textarea><br><br>

        

        <label for="current_projects">Projects:</label>
        <textarea id="current_projects" name="current_projects"></textarea><br><br>

        <h3>Past Companies</h3>

        <div id="companyContainer">
      <!-- Initial company fields -->
      <div class="company-group" id="company_1">
        <label>Company Name:</label>
        <input type="text" name="company_name[]" id="company_name_1" required>

        <label>Role:</label>
        <input type="text" name="role[]" id="role_1" required>

        <label>Experience:</label>
        <input type="number" name="experience[]" id="experience_1" required min="0">

        <button type="button" onclick="removeCompany(1)">Remove</button>
        <br><br>
      </div>
      
    </div>
    <button type="button" onclick="addCompany()">Add Company</button>
    

<!-- Display Added Companies -->
<div id="past_companies_list"></div>

        <h2>Contact Information</h2>
        <hr>
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone"><br><br>

        <label for="linkedin">LinkedIn Profile:</label>
        <input type="url" id="linkedin" name="linkedin"><br><br>

        <label for="github">GitHub Profile:</label>
        <input type="url" id="github" name="github"><br><br>

        <label for="website">Website/Blog:</label>
        <input type="url" id="website" name="website"><br><br>

        

        <h2>Privacy Settings</h2>
        <hr>
        <label>Profile Visibility:</label>
        <input type="radio" id="public" name="visibility" value="public" checked>
        <label for="public">Public</label>
        <input type="radio" id="private" name="visibility" value="private">
        <label for="private">Private</label><br><br>

        <label>Contact Visibility:</label>
        <input type="radio" id="contact_public" name="contact_visibility" value="public">
        <label for="contact_public">Public</label>
        <input type="radio" id="contact_admin" name="contact_visibility" value="admin">
        <label for="contact_admin">Admins Only</label>
        <input type="radio" id="contact_hide" name="contact_visibility" value="hide" checked>
        <label for="contact_hide">Hide</label><br><br>

        <button type="submit" name="submit">Create Profile</button>
    </form>

    
</body>


</html>
<script src = "../js/profile_creation.js"></script>