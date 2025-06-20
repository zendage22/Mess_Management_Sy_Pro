<?php
// Assuming a session is started to track the logged-in student
session_start();
if (!isset($_SESSION['student_name'])) {
    //header('Location: login.php'); // Redirect if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Management - Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style1.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Mess Management</a>
            <span class="navbar-text ms-auto">
                Welcome, <?php echo $_SESSION['student_name']; ?>
            </span>
            //<a href="logout.php" class="btn btn-danger ms-3">Logout</a>
        </div>
    </nav>
