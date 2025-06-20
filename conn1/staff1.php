<?php
session_start();
if (!isset($_SESSION['staff_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    
    <div class="sidebar">
        <h4 class="text-center">Staff Panel</h4>
        <a href="#" onclick="loadPage('attendance.php')">Attendance</a>
        <a href="#" onclick="loadPage('menu.php')">Menu Management</a>
        <a href="#" onclick="loadPage('payments.php')">Payments</a>
        <a href="#" onclick="loadPage('feedback.php')">User Feedback</a>
        <a href="logout.php">Logout</a>
    </div>
    
    <div class="content" id="dashboard-content">
        <h2>Welcome to Staff Dashboard</h2>
        <p>Select an option from the sidebar.</p>
    </div>
    
    <script>
        function loadPage(page) {
            $("#dashboard-content").load(page);
        }
    </script>

</body>
</html>
