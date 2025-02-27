<?php
include('../includes/connection.txt');

//  $stm = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
//  $stm->execute([$user_id]);
//  $flag = $stm->fetch(PDO::FETCH_ASSOC);
$flag=1;
if($_SERVER['REQUEST_METHOD'] == "POST"){
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
                // Insert file data into the database
                // $stmt = $conn->prepare("INSERT INTO user_files (user_id, file_name, file_path) VALUES (:user_id, :file_name, :file_path)");
                // $stmt->bindParam(":user_id", $user_id);
                // $stmt->bindParam(":file_name", $file_name);
                // $stmt->bindParam(":file_path", $file_path);
                // $stmt->execute();

                echo "File uploaded successfully.";
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
$errors = [];

if(!validateBio($bio) && !empty($bio)){
    $errors['bio'] = "bio should only contain letters, spaces, commas only";
}

if(!validateCourse($course)){
    $errors['course'] = "course should only contain letters, spaces, commas only";
}

if(!validateSpecialization($specialization)){
    $errors['specialization'] = "specialization should only contain letters, spaces, commas only";
}


if($flag===0){
// if($user){
//     $stmt = $pdo->prepare("UPDATE user_info1 SET full_name=?, dob=?, gender=?,profile_pic_name=?, profile_pic_path=?, bio=?, graduation_year=?, course_degree=?, specialization=? WHERE user_id=?");
//     $stmt->execute([$name, $dob, $gender, $file_name_new, $file_path_new,$bio,$graduation_year,$course, $specialization]);
// }
// else{
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
    echo "success";
    $errors["status"] = "success";
}
else{
    // foreach($errors as $error){
        
    // }
    echo json_encode($errors);
}
// }

// $v_name = isset($_POST['submit'])? $name: '';
// $v_dob = isset($_POST['submit'])? $dob: '';
// $v_gender = isset($_POST['submit'])? $gender: '';
// $v_bio = isset($_POST['submit'])? $bio: '';

// $v_graduation_year = isset($_POST['submit'])? $graduation_year: '';
// $v_course = isset($_POST['submit'])? $course: '';
// $v_specialization = isset($_POST['submit'])? $specialization: '';

}
else{
    $stmt = $pdo->prepare("UPDATE user_info1 SET full_name=?, dob=?, gender=?,profile_pic_name=?, profile_pic_path=?, bio=?, graduation_year=?, course_degree=?, specialization=? WHERE user_id=?");
    $stmt->execute([$name, $dob, $gender, $file_name_new, $file_path_new,$bio,$graduation_year,$course, $specialization]);
}
}
?>