<?php
include 'conn.php'; // Include the database connection file

// Check if order_id is passed in URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Prepare the DELETE query
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        echo "<script>
                alert('Order deleted successfully!');
                window.location.href='admin.php'; // Redirect back to the order page
              </script>";
    } else {
        echo "<script>
                alert('Error deleting order!');
                window.location.href='admin.php'; 
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>
            alert('Invalid request!');
            window.location.href='admin.php'; 
          </script>";
}
?>
