<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "hospital_management";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete Appointment Record
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM appointments WHERE id = $delete_id");
    header("Location: admin.php");
    exit();
}

// Search Records
$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM appointments WHERE patient_name LIKE '%$search%' OR department LIKE '%$search%' ORDER BY appointment_date DESC";
} else {
    $sql = "SELECT * FROM appointments ORDER BY appointment_date DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Sunrise Community Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">Sunrise Community Hospital</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="book.html">Book Appointment</a></li>
                <li><a href="public-data.html">Public Health Data</a></li>
                <li><a href="admin.php" class="active">Admin Panel</a></li>
            </ul>
        </nav>
    </header>

    <div class="container" style="max-width: 1100px;">
        <h2>Admin Panel - Manage Appointment Records</h2>
        <br>

        <!-- Search Form -->
        <form method="GET" action="admin.php" style="flex-direction: row; gap: 10px;">
            <input type="text" name="search" placeholder="Search patient name or department" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
        <br>

        <!-- Appointment Table -->
        <table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background:#0056b3; color:white;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>National ID</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['national_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['email_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><?php echo $row['appointment_date']; ?></td>
                            <td>
                                <a href="admin.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?')" style="color:red; font-weight:bold;">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
<?php $conn->close(); ?>