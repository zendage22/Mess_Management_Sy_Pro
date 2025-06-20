<?php
include 'conn.php';

$user_id = (int) $_GET['user_id'];

$stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

header("Location: admin.php");
exit();
?>