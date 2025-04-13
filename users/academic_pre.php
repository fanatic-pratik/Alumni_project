<?php
session_start();
$user_id = $_SESSION['user_id'];
include('../includes/connection.txt');
// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $f_name = sanitize($_POST['full_name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $_SESSION['gender'] = $_POST['gender'];
    $bio = sanitize($_POST['bio']);
    $grad_yr = filter_var($_POST['graduation_year'], FILTER_VALIDATE_INT);
    $course_degree = sanitize($_POST['course']);
    $specialization = sanitize($_POST['specialization']);
    $u_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $default_img = "uploads/default.jpg";
// Move file to permanent directory
if (($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
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
                $_SESSION['profile_pic_path']=$file_path;
            }else{
                $_SESSION['profile_pic_path'] = $default_img;
            }
        }else{
            $errors['profile_picture']="File should be less than 2 MB";
        }
    }else{
        $errors['profile_picture']="Invalid file type. Only JPG, PNG, and PDF files are allowed.";
    }
}else{
    $_SESSION['profile_pic_path']=$default_img;
}
}



//                 $file_name_new=$file_name;
//                 $file_path_new=$file_path;
//                 echo "File uploaded successfully.";
//             } else {
//                 $errors['profile_picture']= "Error uploading file.";
//             }
//         } else {
//             $errors['profile_picture']= "File size must be less than 5MB.";
//         }
//     } else {
//         $errors['profile_picture']= "Invalid file type. Only JPG, PNG, and PDF files are allowed.";
//     }
//     $_SESSION['profile_pic_name']=$file_name_new;
//     $_SESSION['profile_pic_path'] = $file_path_new;
// }
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Registration</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; padding: 20px; }
        button { background: green; color: white; padding: 10px; width: 48%; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Preview Your Details</h2>
        <p><strong>Full Name:</strong> <?php echo $f_name; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p><strong>Bio:</strong> <?php echo $bio; ?></p>
        <p><strong>Graduation Year:</strong> <?php echo $grad_yr; ?></p>
        <p><strong>Course:</strong> <?php echo $course_degree; ?></p>
        <p><strong>Specialization:</strong> <?php echo $specialization; ?></p>
        <p><strong>Email:</strong> <?php echo $u_email; ?></p>
        <p><strong>Profile Picture:</strong></p>
        <img src="<?php echo $_SESSION['profile_pic_path']; ?>" width="100px" alt="Profile Picture">

        <form action="academic_submit.php" method="POST">
            <input type="text" name="full_name" value="<?php echo $f_name; ?>" hidden>

            <input type="date" name="dob" value="<?php echo $dob; ?>" hidden>

            <select name="gender" hidden>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <input type="file" name="profile_picture" accept="image/*" value="<?php echo $profile_pic_path; ?>" hidden>

            <textarea name="bio" rows="4" value="<?php echo $bio; ?>" hidden><?php echo $bio; ?></textarea>

            <input type="number" name="graduation_year" min="1900" max="2099" value="<?php echo $grad_yr; ?>" hidden>

            <input type="text" name="course" value="<?php echo $course_degree; ?>" hidden>

            <input type="text" name="specialization" value="<?php echo $specialization; ?>" hidden>

            <input type="email" name="email" value="<?php echo $u_email; ?>" hidden>

            <button type="submit">Confirm & Register</button>
        </form>
        <!-- <form action="register.html">
            <button type="submit">Edit</button>
        </form> -->
        <a href="academic.php"><button type="button">Edit</button></a>
    </div>
</body>
</html>