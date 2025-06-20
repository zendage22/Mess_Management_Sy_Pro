<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conn.php';

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$sql = "SELECT users.name, users.email, purchase_plans.plan_name, purchase_plans.price, purchase_plans.purchase_date 
        FROM purchase_plans 
        INNER JOIN users ON purchase_plans.user_id = users.user_id
        ORDER BY purchase_plans.purchase_date DESC";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Show SQL error
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
