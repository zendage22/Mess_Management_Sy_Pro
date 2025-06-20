<?php
include 'conn.php'; // Include database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['payment_id'])) {
        $payment_id = intval($_POST['payment_id']);
        
        // Prepare and execute the delete query
        $stmt = $conn->prepare("DELETE FROM payments WHERE id = ?");
        $stmt->bind_param("i", $payment_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Payment record deleted successfully!'); window.location.href='user_dash.php';</script>";
        } else {
            echo "<script>alert('Error deleting record!'); window.location.href='user_dash.php';</script>";
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
