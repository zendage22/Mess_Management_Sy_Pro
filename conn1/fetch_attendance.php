<?php
session_start();
include 'conn.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id']) || !isset($_POST['month'])) {
    echo "<tr><td colspan='2' class='text-center'>Unauthorized Access</td></tr>";
    exit();
}

$user_id = $_SESSION['user_id'];
$month = $_POST['month'];

$query = "SELECT date, status FROM attendance WHERE user_id = ? AND DATE_FORMAT(date, '%Y-%m') = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user_id, $month);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>{$row['status']}</td></tr>";
    }
} else {
    echo "<tr><td colspan='2' class='text-center'>No records found</td></tr>";
}

$stmt->close();
$conn->close();
?>
