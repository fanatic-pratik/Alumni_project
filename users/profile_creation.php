<?php
include('../includes/connection.txt');


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
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
    //$user_id = $_SESSION["user_id"]; // Get logged-in user's ID
    $file_name = $_FILES["profile_picture"]["name"];
    $file_tmp = $_FILES["profile_picture"]["tmp_name"];
    $file_size = $_FILES["profile_picture"]["size"];
    $file_type = $_FILES["profile_picture"]["type"];

    // Set upload directory
    $upload_dir = "uploads/";
    // if (!is_dir($upload_dir)) {
    //     mkdir($upload_dir, 0777, true); // Create the directory if not exists
    // }

    // Generate a unique file name to avoid conflicts
    $unique_name = time() . "_" . $file_name;
    $file_path = $upload_dir . $unique_name;

    // Allowed file types (you can modify as needed)
    $allowed_types = ["image/jpeg", "image/png", "application/pdf"];

    if (in_array($file_type, $allowed_types)) {
        if ($file_size < 2 * 1024 * 1024) { // Limit file size to 5MB
            if (move_uploaded_file($file_tmp, $file_path)) {
                $file_name_new=$file_name;
                $file_path_new=$file_path;
                // // Insert file data into the database
                // $stmt = $conn->prepare("INSERT INTO user_files (user_id, file_name, file_path) VALUES (:user_id, :file_name, :file_path)");
                // $stmt->bindParam(":user_id", $user_id);
                // $stmt->bindParam(":file_name", $file_name);
                // $stmt->bindParam(":file_path", $file_path);
                // $stmt->execute();

                // echo "File uploaded successfully.";
            } else {
                $errors['profile_picture']= "Error uploading file.";
            }
        } else {
            $errors['profile_picture']= "File size must be less than 5MB.";
        }
    } else {
        $errors['profile_picture']= "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
    }
}
$graduation_year = filter_var($_POST['graduation_year'], FILTER_VALIDATE_INT);
$course = clean_input($_POST['course']);
$specialization = clean_input($_POST['specialization']);

$job_title = clean_input($_POST['job_titlecurr']);
$company = clean_input($_POST['company']);
$industry = clean_input($_POST['industry']);
$experience = filter_var($_POST['experience'], FILTER_VALIDATE_INT);
$skills = clean_input($_POST['skills']);
$projects = clean_input($_POST['current_projects']);

if(isset($_POST['company_name'])){
    $past_companies = $_POST['company_name'];
}

$phone = clean_input($_POST['phone']);
$linkedin = filter_var($_POST['linkedin'], FILTER_VALIDATE_URL);
$github = filter_var($_POST['github'], FILTER_VALIDATE_URL);
$blog = filter_var($_POST['website'], FILTER_VALIDATE_URL);

$profile = $_POST['visibility'];

function validateName($name) {
    return preg_match("/^[a-zA-Z ]+$/", $name); // Only letters and spaces
}

// Function to validate Batch Year
function validateGraduationYear($graduation_year) {
    return preg_match("/^\d{4}$/", $graduation_year) && $graduation_year >= 1989 && $graduation_year <= date('Y');
}

function validateDOB($dob) {
    return preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(19|20)\d\d$/", $dob, $matches) && (int) $matches[3] >= 1989 && (int) $matches[3] <= date('Y');
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

function validateSkills($skills) {
    return preg_match("/^[\w\s,]+$/u", $skills); // Only letters and spaces and commas ,underscore
}

function validateProjects($projects) {
    return preg_match("/^[\w\s,]+$/u", $projects); // Only letters and spaces and commas ,underscore
}

function validatePhone($phone) {
    $phone = str_replace(' ', '', $phone);
    return preg_match("/^\+?\d{10,15}$/", $phone); // Only letters and spaces and commas ,underscore
}



$errors = [];
// 🛑 Validate Image Upload
// if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
//     $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
//     if (!in_array($_FILES['profile_picture']['type'], $allowed_types) && $_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
//         $errors['profile_picture']= "invalid file type or image size is more than 2mb";
//     }
// }

if(!validateName($name) && !empty($name)){
    $errors['name']= "name should contain letters and spaces only";
}

if(!validateGraduationYear($graduation_year)){
    $errors['graduation_year']= "graduation year should be greater than 2000 and less than current year";
}

if(!empty($dob)){
    if(preg_match("/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(19|20)\d\d$/", $dob, $matches)){
        $year = (int) $matches[3]; // Extract the year
    $currentYear = (int) date('Y');

    if ($year < 1900 || $year > $currentYear) {
        $errors['dob'] = "invalid date of birth";
    } else {
        echo "Valid Date of Birth.";
    }
}
    

}
// if(!validateDOB($dob) && !empty($dob)){
//     $errors['dob'] = "invalid birth-date";
// }

if(!validateBio($bio) && !empty($bio)){
    $errors['bio'] = "bio should only contain letters, spaces, commas only";
}

if(!validateCourse($course)){
    $errors['course'] = "course should only contain letters, spaces, commas only";
}

if(!validateSpecialization($specialization)){
    $errors['specialization'] = "specialization should only contain letters, spaces, commas only";
}

if(!validateJobtitle($job_title) && !empty($job_title)){
    $errors['job_title'] = "Job_title should only contain letters, spaces, commas only";
}

if(!validateCompany($company) && !empty($company)){
    $errors['company'] = "company should only contain letters, spaces, commas only";
}

if(!validateSkills($skills) && !empty($skills)){
    $errors['skills'] = "skills should only contain letters, spaces, commas only";
}

if(!validateProjects($projects) && !empty($projects)){
    $errors['projects'] = "projects should only contain letters, spaces, commas only";
}

if(!validatePhone($phone) && !empty($phone)){
    $errors['phone'] = "phone should only contain numbers, spaces only";
}

$stmt1 = $pdo->prepare("INSERT INTO user_info1 (full_name, dob, gender, profile_pic_name,profile_pic_path,bio, graduation_year, course_degree, specialization) VALUES (:full_name, :dob, :gender, :prof_pic_name,:prof_pic_path,:bio,:grad_yr,:course,:specialization)");
$stmt1->bindParam(":full_name", $name, PDO::PARAM_STR);
$stmt1->bindParam(":dob", $dob, PDO::PARAM_STR);
$stmt1->bindParam(":gender", $gender, PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_name", $file_name_new, PDO::PARAM_STR);
$stmt1->bindParam(":prof_pic_path", $file_path_new, PDO::PARAM_STR);
$stmt1->bindParam(":bio", $bio, PDO::PARAM_STR);
$stmt1->bindParam(":grad_yr", $graduation_year, PDO::PARAM_INT);
$stmt1->bindParam(":course", $course, PDO::PARAM_STR);
$stmt1->bindParam(":specialization", $specialization, PDO::PARAM_STR);

if(empty($errors)){
    $stmt1->execute();
    echo "successful";
    if(!empty($past_companies)){
        foreach($past_companies as $past_company){
            echo $past_company;
        }
    }
    echo $profile;
}
else{
    foreach($errors as $error){
        echo $error;
    }
}

$v_name = isset($_POST['submit'])? $name: '';
$v_dob = isset($_POST['submit'])? $dob: '';
$v_gender = isset($_POST['submit'])? $gender: '';
$v_bio = isset($_POST['submit'])? $bio: '';

$v_graduation_year = isset($_POST['submit'])? $graduation_year: '';
$v_course = isset($_POST['submit'])? $course: '';
$v_specialization = isset($_POST['submit'])? $specialization: '';

$v_job_title = isset($_POST['submit'])? $job_title: '';
$v_company = isset($_POST['submit'])? $company: '';
$v_industry = isset($_POST['submit'])? $industry: '';
$v_experience = isset($_POST['submit'])? $experience: '';
$v_skills = isset($_POST['submit'])? $skills: '';
$v_projects = isset($_POST['submit'])? $projects: '';

$v_phone = isset($_POST['submit'])? $phone: '';
$v_linkedin = isset($_POST['submit'])? $linkedin: '';
$v_github =isset($_POST['submit'])? $github: '';
$v_blog = isset($_POST['submit'])? $blog: '';
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
        <input type="text" id="name" name="name" value="<?php echo isset($_POST['submit'])? $name: '';?>" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $v_dob ; ?>"><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture"><br><br>

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" value="<?php echo $v_bio ; ?>"></textarea><br><br>

        <h2>Academic Information</h2>
        <hr>
        <label for="graduation_year">Graduation Year:</label>
        <input type="number" id="graduation_year" name="graduation_year" value="<?php echo $v_graduation_year ; ?>" required min=1990 max=2025><br><br>

        <label for="course">Course/Degree:</label>
        <input type="text" id="course" name="course" maxlength="20" value="<?php echo isset($_POST['submit'])? $course: ''; ?>" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" value="<?php echo isset($_POST['submit'])? $specialization: ''; ?>" maxlength="20"><br><br>

        <h2>Professional Information</h2>
        <hr>
        <label for="job_title_curr">Job Title:</label>
        <input type="text" id="job_title_curr" name="job_titlecurr" value="<?php echo isset($_POST['submit'])? $job_title: ''; ?>"><br><br>

        <label for="company">Company Name:</label>
        <input type="text" id="company" name="company" value="<?php echo isset($_POST['submit'])? $company: ''; ?>"><br><br>

        <label for="industry">Industry:</label>
        <select id="industry" name="industry">
            <option value="IT">IT</option>
            <option value="Healthcare">Healthcare</option>
            <option value="Finance">Finance</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="experience">Work Experience (Years):</label>
        <input type="number" id="experience" name="experience" value="<?php echo $v_experience ; ?>" min=0 max=30><br><br>

        <label for="skills">Skills:</label>
        <textarea id="skills" name="skills" maxlength="100" value="<?php echo $v_skills ; ?>"></textarea><br><br>

        

        <label for="current_projects">Projects:</label>
        <textarea id="current_projects" name="current_projects" value="<?php echo $v_projects ; ?>"></textarea><br><br>

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