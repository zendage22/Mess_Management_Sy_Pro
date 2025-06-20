<?php
include 'conn.php';

$day = $_GET['day'] ?? 'monday'; // Default to Monday
$menu = ['breakfast' => [], 'lunch' => [], 'dinner' => []];

$query = mysqli_query($conn, "SELECT * FROM meals WHERE day='$day'");

while ($row = mysqli_fetch_assoc($query)) {
    $menu[$row['meal_type']][] = [
        'name' => $row['item_name'],
        'image' => $row['image_path']
    ];
}

echo json_encode($menu);
?>
