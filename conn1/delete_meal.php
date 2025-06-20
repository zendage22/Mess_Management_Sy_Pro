<?php
include 'conn.php';

if (isset($_GET['meal_id'])) {
    $meal_id = $_GET['meal_id'];

    // Fetch image filename to delete from server
    $query = "SELECT meal_image FROM meal WHERE meal_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $meal_id);
    $stmt->execute();
    $stmt->bind_result($meal_image);
    $stmt->fetch();
    $stmt->close();

    // Delete the image file
    if (!empty($meal_image)) {
        unlink("uploads/" . $meal_image);
    }

    // Delete meal from database
    $deleteQuery = "DELETE FROM meal WHERE meal_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $meal_id);

    if ($stmt->execute()) {
        echo "<script>alert('Meal deleted successfully!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting meal!'); window.location.href='admin.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
