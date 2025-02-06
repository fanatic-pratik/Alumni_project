document.addEventListener("DOMContentLoaded", function () {
    let companyCount = 0;

    document.getElementById("add_company").addEventListener("click", function () {
        let companyName = document.getElementById("company_name").value.trim();
        let jobTitle = document.getElementById("job_title").value.trim();
        let duration = document.getElementById("duration").value.trim();

        // 🔴 Validation Checks 🔴
        if (!companyName || !jobTitle || !duration) {
            alert("Please fill out all fields before adding another company.");
            return;
        }
        if (!/^[a-zA-Z\s]+$/.test(companyName)) {
            alert("Company Name should contain only letters and spaces.");
            return;
        }
        if (!/^[a-zA-Z\s]+$/.test(jobTitle)) {
            alert("Job Title should contain only letters and spaces.");
            return;
        }
        if (!/^\d+$/.test(duration) || duration <= 0) {
            alert("Duration must be a positive number.");
            return;
        }

        companyCount++;

        let companyDiv = document.createElement("div");
        companyDiv.className = "company-entry";
        companyDiv.setAttribute("id", `company_${companyCount}`);
        companyDiv.innerHTML = `
            <p><strong>Company:</strong> ${sanitize(companyName)}</p>
            <p><strong>Job Title:</strong> ${sanitize(jobTitle)}</p>
            <p><strong>Duration:</strong> ${sanitize(duration)} years</p>
            <button type="button" class="remove-company" data-id="company_${companyCount}">&#10060; Remove</button>
            <hr>
        `;

        document.getElementById("past_companies_list").appendChild(companyDiv);

        // Clear input fields
        document.getElementById("company_name").value = "";
        document.getElementById("job_title").value = "";
        document.getElementById("duration").value = "";

        companyDiv.querySelector(".remove-company").addEventListener("click", function () {
            let companyId = this.getAttribute("data-id");
            document.getElementById(companyId).remove();
        });
    });

    // Sanitize Input to Prevent XSS Attacks
    function sanitize(input) {
        return input.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    }

    // Profile Picture Validation (Image Only)
    document.getElementById("profile_picture").addEventListener("change", function () {
        let file = this.files[0];
        if (file) {
            let allowedTypes = ["image/jpeg", "image/png", "image/jpg"];
            if (!allowedTypes.includes(file.type)) {
                alert("Only JPEG, JPG, and PNG images are allowed.");
                this.value = ""; // Clear invalid file
            }
            if (file.size > 2 * 1024 * 1024) {
                alert("File size should not exceed 2MB.");
                this.value = "";
            }
        }
    });
});
