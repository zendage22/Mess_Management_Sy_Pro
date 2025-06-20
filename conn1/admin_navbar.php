<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin Dashboard</title>
    <style>
                body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(118, 184, 120); /* Light background color */
            transition: all 0.3s ease-in-out;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 250px;
            position: fixed;
            height: 100%;
            top: 0;
            background-color:rgb(16, 191, 57);
            padding-top: 20px;
            transition: all 0.3s ease-in-out;
        }

        #sidebar .list-unstyled li {
            margin-bottom: 10px;
        }

        #sidebar .list-unstyled li a {
            color: white;
            font-size: 18px;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #sidebar .list-unstyled li a:hover {
            background-color: #495057;
        }

        #page-content-wrapper {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }

        .navbar {
            padding: 15px 20px;
        }

        .navbar .btn {
            background-color: #007bff;
            color: white;
        }

    </style>
</head>
<body>
    
    <!-- Sidebar -->
    <div class="d-flex" id="wrapper">
        <div class="bg-dark text-white p-3" id="sidebar">
            <h2 class="text-center text-white">Admin Panel</h2>
            <ul class="list-unstyled">
                <li><a href="#dashboard" class="text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#users" class="text-white"><i class="fas fa-users"></i> Users</a></li>
                <li><a href="#meals" class="text-white"><i class="fas fa-utensils"></i> Meals</a></li>
                <li><a href="#attendance" class="text-white"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="#reports" class="text-white"><i class="fas fa-chart-line"></i> Reports</a></li>


                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs"></i> Settings
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <a class="dropdown-item" href="help.php"><i class="fas fa-question-circle"></i> Help</a>
                </div>
            </li>
            </ul>
        </div>
</body>
</html>