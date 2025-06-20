<?php
session_start();
include 'conn.php';

$user_id = $_SESSION['user_id'];

// Fetch the latest purchased plan for the user
$sql = "SELECT plans.id as plan_id, plans.plan_name, plans.price 
        FROM plans 
        WHERE user_id = '$user_id' 
        ORDER BY purchase_date DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $plan = $result->fetch_assoc();
    $plan_name = $plan['plan_name'];
    $plan_price = $plan['price'];
    $plan_id = $plan['plan_id'];
} else {
    echo "<p class='text-center text-danger'>No purchased plan found!</p>";
    exit;
}
?>
