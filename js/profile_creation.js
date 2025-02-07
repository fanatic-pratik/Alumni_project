let companyCount = 1;

    function addCompany() {
      companyCount++;
      const companyContainer = document.getElementById("companyContainer");

      // Create a new company group
      const newCompanyGroup = document.createElement("div");
      newCompanyGroup.classList.add("company-group");
      newCompanyGroup.id = "company_" + companyCount;

      newCompanyGroup.innerHTML = `
        <label>Company Name:</label>
        <input type="text" name="company_name[]" id="company_name_${companyCount}" required>

        <label>Role:</label>
        <input type="text" name="role[]" id="role_${companyCount}" required>

        <label>Experience:</label>
        <input type="number" name="experience[]" id="experience_${companyCount}" required min="0">

        <button type="button" onclick="removeCompany(${companyCount})">Remove</button>
        <br><br>
      `;

      companyContainer.appendChild(newCompanyGroup);
    }

    function removeCompany(id) {
      const companyGroup = document.getElementById("company_" + id);
      if (companyGroup) {
        companyGroup.remove();
      }
    }

document.addEventListener("DOMContentLoaded", function () {
    

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
