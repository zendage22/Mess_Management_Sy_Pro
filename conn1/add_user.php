<?php
include 'conn.php'; // Ensure database connection

// Debugging: Print received data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
}

// Get form inputs
$userName = isset($_POST['userName']) ? trim($_POST['userName']) : '';
$userEmail = isset($_POST['userEmail']) ? trim($_POST['userEmail']) : '';
$userRole = isset($_POST['userRole']) ? trim($_POST['userRole']) : '';
$userMobile = isset($_POST['userMobile']) ? trim($_POST['userMobile']) : '';

// Check if any field is empty
if (empty($userName) || empty($userEmail) || empty($userRole) || empty($userMobile)) {
    echo "<script>alert('All fields are required!'); window.location.href = 'admin.php';</script>";
    exit();
}

// Remove non-numeric characters from mobile number
$userMobile = preg_replace('/\D/', '', $userMobile);

// Validate mobile number (should be exactly 10 digits)
if (!preg_match('/^[0-9]{10}$/', $userMobile)) {
    echo "<script>alert('Invalid mobile number. It should be exactly 10 digits.'); 
            window.location.href = 'admin.php';</script>";
    exit();
}

// Check if email already exists
$query = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('User with this email already exists.'); 
            window.location.href = 'admin.php';</script>";
    exit();
}

// Insert data into the database
$sql = "INSERT INTO `user` (`user_id`, `user_name`, `email`, `role`, `mobile`) VALUES (NULL, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $userName, $userEmail, $userRole, $userMobile);

if ($stmt->execute()) {
    echo "<script>alert('Record added successfully'); window.location.href = 'admin.php';</script>";
} else {
    echo "Error inserting: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
