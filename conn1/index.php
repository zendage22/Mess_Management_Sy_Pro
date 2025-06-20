<?php
ob_start(); // Start output buffering
session_start(); // Start session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mess_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare SQL query (Prevents SQL Injection)
    $sql = "SELECT user_id, email, password FROM register WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedPassword = $row['password'];

        // Verify password
        if (password_verify($password, $storedPassword)) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_email'] = $row['email'];

            // Debugging: Check session values before redirecting
            echo "Session user_id: " . $_SESSION['user_id'] . "<br>";
            echo "Session email: " . $_SESSION['user_email'] . "<br>";

            // Redirect to user dashboard
            echo "<script>window.location.href='user_dash.php';</script>";
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}

// Close connection
$conn->close();
?>