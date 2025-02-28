<?php
session_start();
include('../includes/connection.txt');
$sql="select * from user_info1 where user_id=1";
$result= $pdo->query($sql);
$rs = $result->fetch();
if($rs){
    echo "hello";
    $f_name = $rs[1];
    $dob = $rs[2];
    $gender = $rs[3];
    $profile_pic_name = $rs[4];
    $profile_pic_path = $rs[5];
    $bio = $rs[6];
    $grad_yr = $rs[7];
    $course_degree = $rs[8];
    $specialization = $rs[9];
    $u_email = $rs[11];

}else{
    echo "hello";
    $f_name = "";
    $dob = "";
    $gender = "";
    $profile_pic_name = "";
    $profile_pic_path = "";
    $bio = "";
    $grad_yr = "";
    $course_degree = "";
    $specialization = "";
    $u_email = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Registration</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; padding: 20px; }
        input, select, textarea { width: 100%; padding: 8px; margin: 5px 0; }
        button { background: blue; color: white; padding: 10px; width: 48%; }
       
        .progress {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            height: 20px;
            margin-bottom: 20px;
        }
        .progress-bar {
            height: 100%;
            width: 33%; /* Step 2: 66% completion */
            background-color: #4caf50;
            text-align: center;
            color: white;
            line-height: 20px;
            font-weight: bold;
        }
   
    </style>
</head>
<body>
    <div class="container">
        <h2>Alumni Registration Form</h2>
        <div class="progress"><div class="progress-bar" >33%</div></div>

        <form id="registerForm" action="academic_pre.php" method="POST" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo $f_name; ?>" required>

            <label>Date of Birth:</label>
            <input type="date" name="dob" value="<?php echo $dob; ?>" required>

            <label>Gender:</label>
            <select name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Profile Picture:</label>
            <input type="file" name="profile_picture" accept="image/*" required>

            <label>Bio:</label>
            <textarea name="bio" rows="4" value="<?php echo $bio; ?>"><?php echo $bio; ?></textarea>

            <label>Graduation Year:</label>
            <input type="number" name="graduation_year" min="1900" max="2099" value="<?php echo $grad_yr; ?>" required>

            <label>Course/Degree:</label>
            <input type="text" name="course" value="<?php echo $course_degree; ?>" required>

            <label>Specialization:</label>
            <input type="text" name="specialization" value="<?php echo $specialization; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $u_email; ?>" required>

            <button type="submit">Preview</button>
            
        </form>
        <a href="Job_details.html"><button>Next</button></a>
    </div>
</body>
</html>
