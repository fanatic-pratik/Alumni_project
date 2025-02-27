<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['user_id']=1;
include('../includes/connection.txt');
$user_id = $_SESSION["user_id"];
print_r($_SESSION);
echo $user_id;
$stm = $pdo->prepare("SELECT * FROM user_info1 WHERE user_id = ?");
$stm->execute([$user_id]);
$user = $stm->fetch(PDO::FETCH_ASSOC);
echo $user['full_name'];

$is_new_user = !$user;
$profile_picture = $user['profile_pic_name'] ?? 'default-avatar.png'; // Default if no picture
$dob1 = $user['dob'];
$dobFormatted = date("Y-m-d", strtotime($dob1));
// $stm2 = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
// $stm2->execute([$user_id]);
// $flag = $stm2->fetch(PDO::FETCH_ASSOC);



?>
<!-- <!DOCTYPE html>
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
        <input type="text" id="name" name="name" value="<//?php echo isset($_POST['submit'])? $name: '';?>" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<//?php echo $v_dob ; ?>"><br><br>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select><br><br>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture"><br><br>

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" value="<//?php echo $v_bio ; ?>"></textarea><br><br>

        <h2>Academic Information</h2>
        <hr> 
        <label for="graduation_year">Graduation Year:</label>
        <input type="number" id="graduation_year" name="graduation_year" value="<//?php echo $v_graduation_year ; ?>" required min=1990 max=2025><br><br>

        <label for="course">Course/Degree:</label>
        <input type="text" id="course" name="course" maxlength="20" value="<//?php echo isset($_POST['submit'])? $course: ''; ?>" required><br><br>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" value="<//?php echo isset($_POST['submit'])? $specialization: ''; ?>" maxlength="20"><br><br>
        <button type="submit" name="submit">Create Profile</button>
    </form> -->


    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal & Academic Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript" defer></script>
    <!-- <script>
        document.addEventListener("DOMContentLoaded", function () {
    let dobInput = document.getElementById("dob");
    
    dobInput.addEventListener("change", function () {
        let dateValue = new Date(dobInput.value);
        if (!isNaN(dateValue)) {
            let formattedDate = dateValue.toLocaleDateString("en-GB").split('/').reverse().join('-'); 
            dobInput.value = formattedDate; // Convert YYYY-MM-DD to DD-MM-YYYY
        }
    });
});

    </script> -->
</head>
<body>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Personal & Academic Details</h5>
        </div>
        <div class="card-body">
            <form id="personalForm" >
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                <div class="mb-3">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" class="form-control editable" value="<?php echo $user['full_name']?? '';?>" required onchange="isDirty=true;showBtn();" onblur="alert('blur is on.');"><br><br>
                </div>

                <!-- <div class="mb-3">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" placeholder="DD-MM-YYYY" required class="form-control editable" value="<?//php echo $dobFormatted?? ''; ?>"><br><br>
                </div> -->

                <div class="mb-3">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select><br><br>
                </div>

                <!-- <div class="mb-3">
                    <label for="profile_picture">Profile Picture:</label>
                    <input type="file" id="profile_picture" class="form-control editable" name="profile_picture"><br><br>
                </div> -->

                <div class="mb-3">
                    <label for="bio">Bio:</label>
                    <textarea id="bio" name="bio" class="form-control editable" noResize><?php echo $user['bio']?? ''; ?></textarea><br><br>
                </div>

                <div class="mb-3">
                    <label for="graduation_year">Graduation Year:</label>
                    <input type="number" id="graduation_year" class="form-control editable" name="graduation_year" value="<?php echo $user['graduation_year']?? ''; ?>" required min=1990 max=2025 ><br><br>
                </div>

                <div class="mb-3">
                    <label for="course">Course/Degree:</label>
                    <input type="text" class="form-control editable" id="course" name="course" maxlength="20" value="<?php echo $user['course_degree']?? ''; ?>" required><br><br>
                </div> 

                <div class="mb-3">
                    <label for="specialization">Specialization:</label>
                    <input type="text" class="form-control editable" id="specialization" name="specialization" value="<?php echo $user['specialization']; ?>" maxlength="20"><br><br>
                </div>

                <div id="error1" class="error"></div>
                <div id="messageBox"></div>
                <!-- <button type="button" id="editBtn" class="btn btn-warning" onclick="enableEdit()">Edit</button> -->
                <!-- <button type="submit" id="saveBtn" class="btn btn-success" style="display:none;">Save</button> -->
                <button id="dirty" style="display:none;" type="submit" class="btn btn-success">Save</button>
                <?php /* if($is_new_user): ?>
                    
                <?php else: ?>
                    <button type="submit" id="subBtn" class="btn btn-warning">Edit</button>
                    <!-- <button type="submit" id="saveBtn" class="btn btn-success" style="display:none;">Save</button> -->
                <?php endif; */?>
                
            </form>
        </div>
    </div>
</div>

<script>
let isDirty=false;
function showBtn(){
    const btn=document.getElementById('dirty');
    if(isDirty)
        btn.style.display='';
}
console.log("js is running");
// if (typeof jQuery === "undefined"){
//     var script = document.createElement("script");
//         script.src = "https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js";
//         script.onload = function() {
//             console.log("✅ jQuery was reloaded!");
//         };
//         document.head.appendChild(script);
    
// }

// window.$ = window.jQuery = jQuery.noConflict(true);
// console.log("✅ jQuery is now locked in global scope:", $);
// jQuery(document).ready(function() {
//     window.onload = function() {
//     console.log("jquery is running!");
//     if (typeof jQuery === "undefined") {
//         console.error("❌ jQuery is NOT loaded!");
//         return;
//     } else {
//         console.log("✅ jQuery is available:", jQuery.fn.jquery);
//     }
//     jQuery("#personalForm").submit(function(e) {
//         e.preventDefault(); // Prevent page reload
//         console.log("Form submitted!");
//         jQuery(".error").text(""); // Clear previous errors
//         jQuery("#messageBox").text(""); // Clear success message

//         jQuery.ajax({
//             type: "POST",
//             url: "ajax_personal1.php", // Change to your server script
//             data: jQuery(this).serialize(),
//             dataType: "text",
//             success: function(response) {
//                 let jsonResponse = JSON.parse(response);
//         console.log("✅ Parsed JSON:", jsonResponse);
//                 if (jsonResponse.status === "error") {
//                     // Display validation errors
//                     jQuery.each(jsonResponse.errors, function(key, value) {
//                         jQuery("#" + key + "Error").text(value).css("color", "red");
//                     });
//                 } else {
//                     jQuery("#messageBox").text(jsonResponse.message).css("color", "green");
//                     jQuery("#personalForm")[0].reset(); // Reset form on success
//                 }
//             }, error: function(xhr, status, error) {
//                 console.error("❌ AJAX error:", error);
//     console.error("❌ Status:", status);
//     console.error("❌ XHR response:", xhr);
//     console.error("❌ Response Text:", xhr.responseText);
//         }
//         });
//     });
//     return false;
// }
// });
const errorContainer = document.getElementById("error1");
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("personalForm").addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent form from reloading the page
        errorContainer.innerHTML = "";

        let formData = new FormData(this);
        console.log("🔍 Sent Data:", Object.fromEntries(formData.entries()));
        fetch("ajax_personal1.php", {
            method: "POST",
            headers: {
        "Content-Type": "application/x-www-form-urlencoded"
    },
            body: formData
        })
//         .then(response => {
//     console.log("🟢 Fetch Response Object:", response);
    
//     return response.text(); // ✅ Get raw response first
// })
//         // .then(response => response.json()) // Convert response to JSON
//         .then(text => {
//     console.log("✅ Raw Response:", text);  // Debugging - Check if it's valid JSON
//     try {
//         let jsonData = JSON.parse(text);  // ✅ Now parse JSON
//         return jsonData;
//     } catch (error) {
//         console.error("❌ JSON Parse Error:", error);
//         throw new Error("Invalid JSON received from server.");
//     }
// })
//         .then(data => {
//             console.log("✅ Server Response:", data);

//             document.querySelectorAll(".error").forEach(el => el.textContent = ""); // Clear errors
//             document.getElementById("messageBox").textContent = ""; // Clear success message

//             if (data.status === "error") {
//                 // Object.keys(data.errors).forEach(key => {
//                 //     document.getElementById(key + "Error").textContent = data.errors[key];
//                 // });
//                 console.log("🔍 Errors Received:", data.errors);
//                 let errorDiv = document.querySelector(".error"); // Select your single error div
//                 errorDiv.innerHTML = ""; // Clear previous errors

//     // Append all errors inside the div
//                 Object.values(data.errors).forEach(errorMessage => {
//                 let errorParagraph = document.createElement("p");
//                 errorParagraph.textContent = errorMessage;
//                 errorParagraph.style.color = "red"; // Optional: Make errors red
//                 errorDiv.appendChild(errorParagraph);
//     });
//             } else {
//                 document.getElementById("messageBox").textContent = data.message;
//                 document.getElementById("personalForm").reset(); // Reset form
//             }
//         })
.then(response => {
    console.log("✅ Response Object:", response);
    return response.text();  // Get response as text first
})
.then(text => {
    console.log("✅ Raw Response:", text);  // Debugging - Check if it's valid JSON
    return JSON.parse(text);  // Now parse JSON
})
.then(data => {
        if (data.status === "error") {
            // Format all errors into a single message
            let errorMessages = "<ul>";
            Object.keys(data.errors).forEach(key => {
                errorMessages += `<li>${data.errors[key]}</li>`;
            });
            errorMessages += "</ul>";

            errorContainer.innerHTML = errorMessages; // Show errors in the single div
            errorContainer.style.display = "block"; // Make sure it is visible
        } else {
            alert("Form submitted successfully!");
            errorContainer.innerHTML = ""; // Clear errors on success
        }
    })
        .catch(error => console.error("❌ Fetch Error:", error));
    });
});

</script>

</body>
</html>

</body>
</html>