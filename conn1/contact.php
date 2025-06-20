<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default username in XAMPP
$password = ""; // Default password is empty
$dbname = "mess_management_system"; // Database name you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us - Mess Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {        
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-image: url('login.png'); /* Add your background image here */
            background-size: cover; /* Makes sure the background covers the whole page */
            background-position: center; /* Center the background image */
            background-attachment: fixed; /* Keeps the background fixed while scrolling */
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
        .container {
            max-width: 1200px;
            margin-top: 80px;
            padding: 60px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #72ba8e, #76af86);
            color: #fff;
        }

        .section-title {
            font-family: 'Roboto', sans-serif;
            font-size: 40px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .contact-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .contact-info .info-item {
            width: 30%;
            text-align: center;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: #6c757d; /* Grey color */
        }

        .contact-info .info-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
        }

        .contact-info .info-item i {
            font-size: 30px;
            color: #34be65;
            margin-bottom: 15px;
        }

        .contact-info .info-item h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .contact-form textarea {
            height: 150px;
        }

        .contact-form button {
            padding: 12px 20px;
            background-color: #34be65;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #28a745;
        }

        .google-map {
            margin-top: 40px;
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 10px;
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

        /* Media Queries */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .container {
                padding: 30px;
                width: 90%;
            }

            .section-title {
                font-size: 28px;
            }

            .contact-info {
                flex-direction: column;
                align-items: center;
            }

            .contact-info .info-item {
                width: 80%;
                margin-bottom: 20px;
            }

            .google-map {
                height: 300px;
            }
        }

         /* Dropdown Customization */
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
            <a class="navbar-brand" href="#">
                <img src="logo.png" alt="Logo" style="height: 60px;"> Mess Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-home"></i>Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="menu.html"><i class="fas fa-utensils"></i>Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="service.php"><i class="fas fa-concierge-bell"></i>Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html"><i class="fas fa-info-circle"></i>About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php"><i class="fas fa-phone-alt"></i>Contact</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-sign-in-alt"></i>Login
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                           
                            <li><a class="dropdown-item" href="index.html"><i class="fas fa-user"></i> User Login</a></li>
                            <li><a class="dropdown-item" href="staff_login.php"><i class="fas fa-users-cog"></i> Staff Login</a></li>
                            <li><a class="dropdown-item" href="admin_login.php"><i class="fas fa-user-shield"></i> Admin Login</a></li>
                        </ul>
                    </li>                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Us Section -->
    <div class="container">
        <h2 class="section-title">Contact Us</h2>

        <div class="contact-info">
            <!-- Address -->
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <h5>Our Address</h5>
                <p>Mauli Mess ,Shardanagar,Tal.Baramati</p>
            </div>
            <!-- Phone -->
            <div class="info-item">
                <i class="fas fa-phone-alt"></i>
                <h5>Phone</h5>
                <p>8010317549</p>
            </div>
            <!-- Email -->
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <h5>Email</h5>
                <p>poojazendage@gmail.com</p>
            </div>
        </div>

        <!-- Contact Form -->
        <h3 class="section-title">Send Us a Message</h3>
        <div class="contact-form">
            <form action="contact.php" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>

        <!-- Google Map -->
        <h3 class="section-title">Find Us Here</h3>
        <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.328408883366!2d106.74832031536699!3d10.823019892295126!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752c32c9b3b023%3A0x8c1a4e348200d283!2sB%C3%ACnh%20H%C3%A0o%20Mall!5e0!3m2!1sen!2s!4v1682731847432!5m2!1sen!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
