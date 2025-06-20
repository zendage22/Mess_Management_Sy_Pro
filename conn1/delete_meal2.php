<?php
include 'conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM meals WHERE id = $id");
}

header("Location: admin.php");
exit();
?>
