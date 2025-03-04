<!DOCTYPE html>
<html lang="en">
<head>
    <title>Step 2: Job Details</title>
    <script>
        function addPastCompany() {
            let container = document.getElementById('pastCompaniesContainer');
            let div = document.createElement('div');
            div.innerHTML = `
                <input type="text" name="past_company_name[]" placeholder="Past Company Name" required>
                <input type="text" name="past_role[]" placeholder="Role" required>
                <input type="number" name="past_experience[]" placeholder="Experience (years)" required min="0">
                <button type="button" onclick="this.parentElement.remove()">Remove</button>
                <br>`;
            container.appendChild(div);
        }
    </script>
    <style>
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
            width: 66%; /* Step 2: 66% completion */
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
        <h2>Step 2: Job Details</h2>
        <div class="progress"><div class="progress-bar" >66%</div></div>
        <div style="width:80%">
        <button onclick="window.location.href='job_detail1.php';">Add New</button><br>
            <table border=1 style="width:100%;border-collapse: collapse;" >
                <tr>
                <th>Sr.</th>
                <th>Company Name</th>
                <th>Exp yrs</th>
                <th>Designation</th>
                <th>Edit</th>
                <th>Del</th>
                </tr>
            <?php
            include('../includes/connection.txt');
            $ctr=0;
            $sql= "select * from job_profile_curr where user_id=1";
            $result=$pdo->query($sql);
            while($rs=$result->fetch()){
                $ctr++;
            ?>
               <tr>
               <td><?php echo $ctr ; ?></td>
               <td><?php echo $rs[3] ; ?></td>
               <td><?php echo $rs[5] ; ?></td>
               <td><?php echo $rs[2]; ?></td>
               <td><button onClick="window.location.href='edit_job_details.php?id=<?php echo $rs[0];?>'">Edit</button></td>
                <td><button onClick="window.location.href='delete_job_details.php?id=<?php echo $rs[0];?>'">Delete</button></td>
                </tr>
            
            <?php    
            } 
            //loop
            //echo "<tr><TD>$dd</TD>"
            //<td><button>Edit</button></td><td><button>Del</td>
            ?>
            </table>
        </div>
        <!-- <form action="job_detail1.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="job_title" placeholder="Job Title" required>
            <input type="text" name="company_name" placeholder="Company Name" required>
            <input type="text" name="industry" placeholder="Industry" required>
            <input type="number" name="work_experience" placeholder="Years of Experience" required min="0">
            <textarea name="skills" placeholder="Skills"></textarea>
            <textarea name="projects" placeholder="Projects"></textarea>

            <h3>Past Companies</h3>
            <div id="pastCompaniesContainer">
                <button type="button" onclick="addPastCompany()">+ Add More</button>
            </div> 

            
            <button type="submit">Preview</button>
        </form> -->
        
        <a href="academic.php"><button type="button">Previous</button></a>
        <a href="contact_info.php"><button>Next</button></a>
    </div>
</body>
</html>
