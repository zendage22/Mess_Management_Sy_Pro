
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "mess_management_system");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $services = mysqli_real_escape_string($conn, $_POST['services']);
    $total = floatval($_POST['total']);
    $payment_type = mysqli_real_escape_string($conn, $_POST['payment_type']);
    $payment_mode = mysqli_real_escape_string($conn, $_POST['payment_mode']);
    $order_status = ($payment_mode === 'online') ? 'Successful' : 'Pending';

    // Get formatted menu items (like "Roti Sabzi - 2, Dal Chawal - 3")
    $selected_items = mysqli_real_escape_string($conn, $_POST['selected_items']);

    // Insert into database
    $sql = "INSERT INTO orders (name, phone_no, email_id, address, services, menu_item, total, payment_type, payment_mode, order_status) 
            VALUES ('$name', '$phone_no', '$email_id', '$address', '$services', '$selected_items', '$total', '$payment_type', '$payment_mode', '$order_status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Order placed successfully!'); window.location.href='order1.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mess Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar Brand Styling */
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

        .hero-section {
            background-image: url("register.png");
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ff6600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        .service-icons {
            font-size: 3rem;
            color: #007bff;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
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

        /* Navbar Toggler */
        .navbar-toggler {
            border-color: #007bff;
        }

        .navbar-toggler-icon {
            background-color: #007bff;
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

        /* Review Section - Dynamic Scroll */
        .review-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding: 50px 0;
            background-color: #f9f9f9;
        }

        .review-carousel {
            display: flex;
            transition: transform 0.5s ease;
        }

        .review-item {
            flex: 0 0 100%;
            max-width: 100%;
            padding: 20px;
            text-align: center;
            box-sizing: border-box;
        }

        .review-item .review-text {
            font-size: 1.1rem;
            font-style: italic;
            color: #555;
        }

        .review-item .reviewer-name {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .review-item .reviewer-rating {
            font-size: 1.5rem;
            color: #ff6600;
        }

        .scroll-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .scroll-arrow-left {
            left: 0;
        }

        .scroll-arrow-right {
            right: 0;
        }


        .form-card {
            max-width: 850px;
            margin: auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: scale(1.02);
            box-shadow: 0px 6px 18px rgba(0, 0, 0, 0.2);
        }

        .form-card h2 {
            font-weight: bold;
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .menu-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .menu-item-row input[type="number"] {
            width: 60px;
            text-align: center;
            border-radius: 5px;
        }

        .btn-submit {
            width: 100%;
            font-size: 18px;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 10px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-submit:hover {
            background: #0056b3;
            transform: scale(1.05);
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


    <div class="container mt-5">
        <div class="form-card">
            <h2><i class="fas fa-shopping-cart"></i> Place Your Order</h2>
            <form method="POST">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label"><i class="fas fa-user"></i> Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_no" class="form-label"><i class="fas fa-phone"></i> Phone No</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" required>
                        </div>

                        <div class="mb-3">
                            <label for="email_id" class="form-label"><i class="fas fa-envelope"></i> Email ID</label>
                            <input type="email" class="form-control" id="email_id" name="email_id" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label"><i class="fas fa-map-marker-alt"></i> Address</label>
                            <textarea class="form-control" id="address" name="address" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="services" class="form-label"><i class="fas fa-utensils"></i> Services</label>
                            <select class="form-select" id="services" name="services" onchange="updateMenuItems()">
                                <option value="tiffin">Tiffin</option>
                                <option value="event">Event</option>
                                <option value="parcel">Parcel</option>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Select Menu Items</label>
                            <div id="menu_items_list"></div>
                        </div>
                        <input type="hidden" id="selected_items" name="selected_items"> <!-- Hidden Input -->


                        <!--<div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" required oninput="updateTotal()">
                </div>-->

                        <div class="mb-3">
                            <label for="total" class="form-label">Total (₹)</label>
                            <input type="text" class="form-control" id="total" name="total" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select class="form-select" id="payment_mode" name="payment_mode" onchange="togglePaymentType()">
                                <option value="offline">Offline</option>
                                <option value="online">Online</option>
                            </select>
                        </div>

                        <div class="mb-3" id="payment_type_div">
                            <label for="payment_type" class="form-label">Payment Type</label>
                            <select class="form-select" id="payment_type" name="payment_type">
                                <option value="googlepay">Google Pay</option>
                                <option value="phonepe">PhonePe</option>
                                <option value="card">Card</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Submit Order</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Mess Management System. All Rights Reserved.</p>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>
    </body>

    <script>
 const menuItems = {
    tiffin: [{ name: "Roti Sabzi", price: 50 }, { name: "Dal Chawal", price: 60 }, { name: "Paneer Masala", price: 80 }],
    event: [{ name: "Biryani", price: 150 }, { name: "Butter Chicken", price: 200 }, { name: "Veg Thali", price: 180 }],
    parcel: [{ name: "Sandwich", price: 40 }, { name: "Pasta", price: 70 }, { name: "Burger", price: 90 }]
};

function updateMenuItems() {
    const serviceType = document.getElementById("services").value;
    const menuList = document.getElementById("menu_items_list");
    menuList.innerHTML = "";

    menuItems[serviceType].forEach(item => {
        let row = document.createElement("div");
        row.classList.add("menu-item-row");

        let checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = item.name;
        checkbox.name = "menu_item[]"; // Store as an array
        checkbox.onchange = updateTotal;

        let label = document.createElement("label");
        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(` ${item.name} - ₹${item.price}`));

        let quantity = document.createElement("input");
        quantity.type = "number";
        quantity.value = 1;
        quantity.min = 1;
        quantity.name = "quantity[]"; // Store quantity as an array
        quantity.oninput = updateTotal;

        row.appendChild(label);
        row.appendChild(quantity);
        menuList.appendChild(row);
    });
}

function updateTotal() {
    let total = 0;
    let selectedItems = [];

    document.querySelectorAll(".menu-item-row").forEach(row => {
        let checkbox = row.querySelector("input[type='checkbox']");
        let quantity = row.querySelector("input[type='number']");

        if (checkbox.checked && quantity.value > 0) {
            let itemName = checkbox.value;
            let itemQuantity = quantity.value;
            total += itemQuantity * menuItems.tiffin.find(item => item.name === itemName).price;
            selectedItems.push(`${itemName} - ${itemQuantity}`); // Store formatted data
        }
    });

    document.getElementById("total").value = total;
    document.getElementById("selected_items").value = selectedItems.join(", "); // Store as a single string
}

document.addEventListener("DOMContentLoaded", function () {
    updateMenuItems();
});

        function togglePaymentType() {
            document.getElementById("payment_type_div").style.display =
                document.getElementById("payment_mode").value === "offline" ? "none" : "block";
        }

        document.addEventListener("DOMContentLoaded", function () {
            updateMenuItems();
            togglePaymentType();
        });

// Function to validate form before submission
function validateForm(event) {
    var name = document.getElementById("name").value;
    var phone_no = document.getElementById("phone_no").value;
    var email_id = document.getElementById("email_id").value;
    var quantity = document.getElementById("quantity").value;
    var address = document.getElementById("address").value;

    var namePattern = /^[A-Za-z\s]+$/;
    var phonePattern = /^[0-9]{10}$/;
    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!namePattern.test(name)) {
        alert("Name should contain only characters.");
        event.preventDefault();
        return false;
    }

    if (!phonePattern.test(phone_no)) {
        alert("Phone number must be exactly 10 digits.");
        event.preventDefault();
        return false;
    }

    if (!emailPattern.test(email_id)) {
        alert("Please enter a valid email with '@'.");
        event.preventDefault();
        return false;
    }

    if (quantity <= 0) {
        alert("Quantity must be greater than zero.");
        event.preventDefault();
        return false;
    }

    if (address.trim() === "") {
        alert("Address cannot be empty.");
        event.preventDefault();
        return false;
    }

    return true;
}

// Attach validation to form submission
document.querySelector("form").addEventListener("submit", validateForm);


    </script>
</html>