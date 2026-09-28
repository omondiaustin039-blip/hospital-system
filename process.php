<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "hospital_management";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name     = trim($_POST['patient_name']);
    $national_id      = trim($_POST['national_id']);
    $gender           = trim($_POST['gender']);
    $phone_number     = trim($_POST['phone_number']);
    $email            = trim($_POST['email']);
    $department       = trim($_POST['department']);
    $appointment_date = $_POST['appointment_date'];

    // PHP Validation
    if (empty($patient_name) || empty($national_id) || empty($gender) || empty($phone_number) || empty($email) || empty($department) || empty($appointment_date)) {
        die("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address format.");
    }

    $stmt = $conn->prepare("INSERT INTO appointments (patient_name, national_id, gender, phone_number, email_address, department, appointment_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $patient_name, $national_id, $gender, $phone_number, $email, $department, $appointment_date);

    if ($stmt->execute()) {
        echo "<h3 style='color:green;'>Appointment booked successfully!</h3>";
        echo "<a href='index.html'>Back to Home</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>