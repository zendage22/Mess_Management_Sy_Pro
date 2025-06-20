<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }
        .navbar-toggler {
            border: none;
            color: white;
        }
        .navbar-toggler:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>
<body>

    <!-- Simple Horizontal Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="fas fa-bars"></span> <!-- 3-line (hamburger) menu icon -->
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="#users"><i class="fas fa-users"></i> Users</a></li>
                <li class="nav-item"><a class="nav-link" href="#meals"><i class="fas fa-utensils"></i> Meals</a></li>
                <li class="nav-item"><a class="nav-link" href="#attendance"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="#reports"><i class="fas fa-chart-line"></i> Reports</a></li>
                <li class="nav-item"><a class="nav-link" href="#purchase-plan"><i class="fas fa-shopping-cart"></i> Purchase Plan</a></li>
                <li class="nav-item"><a class="nav-link" href="#orders"><i class="fas fa-box"></i> Orders</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="settingsDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-cogs"></i> Settings
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        <a class="dropdown-item" href="help.php"><i class="fas fa-question-circle"></i> Help</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-4">
        <h1>Welcome to Admin Panel</h1>
        <p>This is the main content area.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
