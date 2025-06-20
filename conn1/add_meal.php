<?php
include 'conn.php';

if (isset($_POST['addMeal'])) {
    $mealName = $_POST['mealName'];
    $mealCategory = $_POST['mealCategory'];
    $mealPrice = $_POST['mealPrice'];

    // Handle image upload
    $targetDir = "uploads/";
    $fileName = basename($_FILES["mealImage"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["mealImage"]["tmp_name"], $targetFilePath)) {
            // Insert into database
            $sql = "INSERT INTO meal (meal_name, meal_category, meal_price, meal_image) VALUES ('$mealName', '$mealCategory', '$mealPrice', '$fileName')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Meal added successfully!'); window.location.href='admin.php';</script>";
            } else {
                echo "<script>alert('Error adding meal: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image.');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
    }
}
?>
