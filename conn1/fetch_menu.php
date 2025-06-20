<?php
$servername = "localhost"; // Change if necessary
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "mess_management_system"; // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected day from AJAX request
$day = isset($_GET['day']) ? $_GET['day'] : 'monday';

$sql = "SELECT meal_type, item_name, image_path FROM menu WHERE day = '$day'";
$result = $conn->query($sql);

$menu = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menu[$row["meal_type"]][] = [
            "name" => $row["item_name"],
            "image" => $row["image_path"]
        ];
    }
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($menu);
?>
