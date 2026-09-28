// Task 3: JavaScript Form Validation
function validateForm() {
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone_number").value;
    const appointmentDate = document.getElementById("appointment_date").value;
    const errorMessage = document.getElementById("error-message");

    errorMessage.innerText = "";

    // Validate Email Address Format
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        errorMessage.innerText = "Please enter a valid email address.";
        return false;
    }

    // Validate Phone Number Format (digits only, length 10-15)
    const phonePattern = /^[0-9]{10,15}$/;
    if (!phonePattern.test(phone)) {
        errorMessage.innerText = "Phone number must contain between 10 and 15 digits.";
        return false;
    }

    // Prevent Selection of Past Appointment Dates
    const selectedDate = new Date(appointmentDate);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
        errorMessage.innerText = "Appointment date cannot be in the past.";
        return false;
    }

    return true;
}

// Task 7: Dynamic API Data Fetching for public-data.html
document.addEventListener("DOMContentLoaded", function () {
    const displayContainer = document.getElementById("apiData");

    if (displayContainer) {
        fetch("api.php")
            .then(response => response.json())
            .then(data => {
                if (!data || data.length === 0) {
                    displayContainer.innerHTML = "<p>No appointment records found in API.</p>";
                    return;
                }

                let tableHTML = `<table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background:#0056b3; color:white;">
                            <th>ID</th>
                            <th>Patient Name</th>
                            <th>Department</th>
                            <th>Appointment Date</th>
                        </tr>
                    </thead>
                    <tbody>`;

                data.forEach(item => {
                    tableHTML += `<tr>
                        <td>${item.id}</td>
                        <td>${item.patient_name}</td>
                        <td>${item.department}</td>
                        <td>${item.appointment_date}</td>
                    </tr>`;
                });

                tableHTML += `</tbody></table>`;
                displayContainer.innerHTML = tableHTML;
            })
            .catch(err => {
                displayContainer.innerText = "Error retrieving API data.";
            });
    }
});