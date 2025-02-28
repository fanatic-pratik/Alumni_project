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

        <form action="job_details_preview.php" method="POST" enctype="multipart/form-data">
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
        </form>
        <a href="register.html"><button type="button">Previous</button></a>
        <a href="contact_info.html"><button>Next</button></a>
    </div>
</body>
</html>
