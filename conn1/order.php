<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "mess_management_system"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $meal_plan = $_POST['meal_plan'];
    $menu_item = $_POST['menu_item']; // Capture the selected menu item
    
    // Prepare and bind SQL statement
    $sql = "INSERT INTO customer (name, email, phone, address, meal_plan, menu_item) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $address, $meal_plan, $menu_item);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Confirm order!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mess Management System - Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            background-image: url('login.png'); /* Add your background image here */
            background-size: cover;
            background-position: center;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #21b181 !important;
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

        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }

        footer a {
            color: #007bff;
        }

        footer a:hover {
            color: #ff6600;
        }

        /* Form Styling */
        .form {
            background-color: rgba(255, 255, 255, 0.8); /* Slight transparent background for the form */
            padding: 30px;
            border-radius: 8px;
            border: 2px solidrgb(11, 41, 6); /* Adding a blue border */
            box-shadow: 0 4px 8px rgba(22, 1, 1, 0.2);
            margin-top: 50px;
            max-width: 500px; /* Smaller form width */
            margin-left: auto;
            margin-right: auto;
            backdrop-filter: blur(5px); /* Adds blur effect to background */
        }

        .form h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .btn-primary {
            background-color:rgb(121, 200, 134);
            border-color:rgb(147, 215, 174);
            color: white;
            font-size: 1.1rem;
            padding: 12px 20px;
            width: 100%;
        }

        .btn-primary:hover {
            background-color:rgb(10, 76, 36);
            border-color:rgb(16, 95, 46);
        }

        .form-control:focus {
            border-color:rgb(7, 68, 36); /* Blue border on focus */
            box-shadow: 0 0 5px rgba(10, 150, 83, 0.5); /* Light blue shadow on focus */
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
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.html"><i class="fas fa-utensils"></i> Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ser.html"><i class="fas fa-concierge-bell"></i> Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html"><i class="fas fa-info-circle"></i> About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php"><i class="fas fa-phone"></i> Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.html"><i class="fas fa-user-plus"></i> Registration</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registration Form Section -->
    <div class="container">
        <div class="form">
            <h2>Order</h2>
            <form method="POST" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="meal_plan" class="form-label">Preferred Meal Plan</label>
                    <select class="form-select" id="meal_plan" name="meal_plan" required onchange="updateMenu()">
                        <option value="Breakfast">Breakfast</option>
                        <option value="Lunch">Lunch</option>
                        <option value="Dinner">Dinner</option>
                        <option value="Full Day">Full Day</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="menu_item" class="form-label">Menu Item</label>
                    <select class="form-select" id="menu_item" name="menu_item" required>
                        <!-- Default empty options that will be updated by JavaScript -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2025 Mess Management System. All Rights Reserved.</p>
            <p>Follow us on <a href="#">Facebook</a> | <a href="#">Instagram</a></p>
        </div>
    </footer>

    <!-- Bootstrap JS and Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.0/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Simple form validation
        function validateForm() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const mealPlan = document.getElementById('meal_plan').value;
            const menuItem = document.getElementById('menu_item').value;

            if (!name || !email || !phone || !address || !mealPlan || !menuItem) {
                alert("All fields are required!");
                return false;
            }

            return true;
        }

        // Update menu items based on the selected meal plan
        function updateMenu() {
            const mealPlan = document.getElementById('meal_plan').value;
            const menuSelect = document.getElementById('menu_item');

            // Clear existing options
            menuSelect.innerHTML = '';

            // Add menu items based on selected meal plan
            if (mealPlan === 'Breakfast') {
                const breakfastItems = ['Pancakes', 'Omelette', 'Cereal', 'Toast', 'Fruit Salad'];
                breakfastItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    menuSelect.appendChild(option);
                });
            } else if (mealPlan === 'Lunch') {
                const lunchItems = ['Grilled Chicken', 'Veggie Pasta', 'Burger', 'Salad', 'Sandwich'];
                lunchItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    menuSelect.appendChild(option);
                });
            } else if (mealPlan === 'Dinner') {
                const dinnerItems = ['Steak', 'Spaghetti', 'Pizza', 'Grilled Fish', 'Rice and Beans'];
                dinnerItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    menuSelect.appendChild(option);
                });
            } else if (mealPlan === 'Full Day') {
                const fullDayItems = ['Breakfast, Lunch & Dinner', 'Custom Meal Plan'];
                fullDayItems.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    menuSelect.appendChild(option);
                });
            }
        }

        // Initialize menu items on page load based on default meal plan
        window.onload = function() {
            updateMenu();
        }
    </script>
</body>
</html>
