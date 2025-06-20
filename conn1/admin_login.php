<?php
// Start session to manage login state
ob_start(); // Start output buffering
session_start(); // Start session

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect input data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Dummy credentials (Replace with real credentials from a database)
    $admin_username = 'admin';
    $admin_password = 'admin123';

    // Check if credentials are correct
    if ($username == $admin_username && $password == $admin_password) {
        $_SESSION['admin'] = $username; // Set session variable
        header('Location: admin1.php'); // Redirect to admin dashboard
        exit();
    } else {
        $error_message = 'Invalid Username or Password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login - Mess Management System</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f3f5;
        }

        /* Login Container with background image */
        .login-container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('php_img/admin.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
            z-index: 0;
        }

        /* Dark overlay over background image */
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            font-weight: 700;
            color: #28a745;
        }

        .login-form .form-control {
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .login-form .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .login-form .btn-primary {
            background-color: #28a745;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 1.2rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form .btn-primary:hover {
            background-color: #218838;
        }

        .login-form .error-message {
            color: #dc3545;
            text-align: center;
            margin-top: 10px;
        }

        .login-form a {
            color: #007bff;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
        }

        .forgot-password a {
            font-size: 0.9rem;
            color: #007bff;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;  /* Smaller brand name */
            color: #34be65 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .navbar-brand:hover {
            color: #ff6600 !important;
            text-shadow: 0 0 10px rgba(255, 102, 0, 0.7);
        }

        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Navbar Menu Styling */
        .navbar .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 1.1rem;
            text-transform: uppercase;
            padding: 12px 20px;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .navbar .navbar-nav .nav-link:hover {
            background-color: #007bff;
            border-radius: 30px;
            color: white !important;
        }

        .navbar .navbar-nav .nav-link.active {
            color: #ff6600 !important;
            font-weight: 600;
        }

        /* Adding Font Awesome Icons */
        .navbar .navbar-nav .nav-item i {
            margin-right: 8px;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .navbar .navbar-nav .nav-item:hover i {
            transform: scale(1.2);
            color: #ff6600;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-top: 100px;
        }

        .footer a {
            color: #007bff;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #ff6600;
        }

        .footer .social-icons a {
            margin: 0 10px;
            font-size: 1.5rem;
            color: #fff;
            transition: color 0.3s ease;
        }

        .footer .social-icons a:hover {
            color: #ff6600;
        }

        .dropdown-menu {
            background-color: #343a40;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            color: #fff !important;
            font-size: 1.1rem;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #007bff;
            color: #fff !important;
        }

        .dropdown-item i {
            margin-right: 10px;
            color: #ff6600;
            transition: color 0.3s ease;
        }

        .dropdown-item:hover i {
            color: #fff;
        }

        .dropdown-toggle::after {
            margin-left: 10px;
            color: #fff;
            transition: transform 0.3s ease;
        }

        .dropdown-toggle:focus {
            outline: none;
        }

        .dropdown-toggle:hover::after {
            transform: rotate(180deg);
        }


    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo and Brand Name -->
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="Logo" style="height: 60px;"> Mess Management
            </a>
            <!-- Navbar Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.html"><i class="fas fa-utensils"></i>Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ser.html"><i class="fas fa-concierge-bell"></i>Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html"><i class="fas fa-info-circle"></i>About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php"><i class="fas fa-phone-alt"></i>Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                           
                            <li><a class="dropdown-item" href="index.html"><i class="fas fa-user"></i> User Login</a></li>
                            <li><a class="dropdown-item" href="staff_login.php"><i class="fas fa-users-cog"></i> Staff Login</a></li>
                            <li><a class="dropdown-item" href="admin_login.php"><i class="fas fa-user-shield"></i> Admin Login</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-form">
            <h2>Admin Login</h2>

            <!-- Error Message (if invalid login) -->
            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>

            <!-- Register or Back Link -->
            <div class="mt-3">
                <a href="#">Back to Homepage</a>
            </div>
        </div>
    </div>

     <!-- Footer -->
     <footer class="footer">
        <p>&copy; 2025 Mess Management System. All Rights Reserved.</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
