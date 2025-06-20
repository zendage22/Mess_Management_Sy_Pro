<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Mess Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f4f7f6; margin: 0; }
        .main-content { margin-top: 80px; padding: 60px; }
        .services-list { display: flex; justify-content: space-around; flex-wrap: wrap; background-color: #fff; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .service-option { display: flex; align-items: center; background-color: #21b181; color: white; padding: 15px; border-radius: 10px; cursor: pointer; transition: all 0.3s ease; font-size: 1.2rem; }
        .service-option:hover { background-color: #ff6600; transform: scale(1.05); }
        .service-option i { margin-right: 10px; font-size: 1.5rem; }
        .service-section { display: none; background-color: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-top: 20px; }
        .order-item { text-align: center; margin: 15px; }
        .order-item img { width: 250px; height: 200px; border-radius: 10px; object-fit: cover; }
        .order-item button { margin-top: 10px; }
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


/* Footer */
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

        .regular-mess-section {
            background: linear-gradient(135deg, #ff6a00, #ee0979);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            margin-top: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .regular-mess-section:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        }
        .regular-mess-section h4 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .regular-mess-section p, .regular-mess-section ul {
            font-size: 1.3rem;
        }
        .regular-mess-section ul {
            list-style: none;
            padding: 0;
        }
        .regular-mess-section li {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 500;
        }
        .regular-mess-section li:last-child {
            border-bottom: none;
        }
        .regular-mess-section i {
            margin-right: 12px;
            font-size: 1.5rem;
            color: #ffe100;
        }
        .highlight {
            font-weight: bold;
            color: #ffe100;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
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


    <div class="main-content">
        <h2 class="text-center">Our Services</h2>
        <div class="services-list">
            <div class="service-option" id="ordersBtn"><i class="fas fa-box-open"></i> Orders</div>
            <div class="service-option" id="homeDeliveryBtn"><i class="fas fa-truck"></i> Home Delivery</div>
            <div class="service-option" id="parcelBtn"><i class="fas fa-archive"></i> Parcel</div>
            <div class="service-option" id="regularMessBtn"><i class="fas fa-clipboard-list"></i> Regular Mess</div>
        </div>
        
        <div class="service-section" id="ordersSection">
            <h4>Orders</h4>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="order-item"><img src="php_img/birthday.jpg"><p>Birthday Order</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/event.jpg"><p>Event Order</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/festival.jpg"><p>Festival Order</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/community.jpg"><p>Community Event</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/corporate.jpg"><p>Corporate Order</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/occassion.jpg"><p>Special Occasions</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
            </div>
        </div>

        <div class="service-section" id="homeDeliverySection">
            <h4>Home Delivery</h4>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="order-item"><img src="php_img/tiffinbox1.png"><p>Regular Meals</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/tiffinbox2.jpg"><p>Fast Food</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/tiffinbox3.jpg"><p>Special Orders</p><button class="btn btn-success order-btn" data-link="order1.php">Order</button></div>
            </div>
        </div>

        <div class="service-section" id="parcelSection">
            <h4>Parcel</h4>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="order-item"><img src="php_img/pasta.jpg"><p>Pasta</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/sandwhich.jpg"><p>sandwhich</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/vadapav.jpg"><p>Vadapav</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/burger.jpg"><p>Burger</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/samosa.jpg"><p>Samosa</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
                <div class="order-item"><img src="php_img/kacori.jpg"><p>Kacori</p><button class="btn btn-warning order-btn" data-link="order1.php">Order</button></div>
            </div>
        </div>

        <div class="service-section regular-mess-section" id="regularMessSection">
            <h4><i class="fas fa-utensils"></i> Regular Mess Information</h4>
            <p><strong class="highlight">Timings:</strong></p>
            <ul>
                <li><i class="fas fa-coffee"></i> Breakfast: <span class="highlight">7:00 AM - 9:30 AM</span></li>
                <li><i class="fas fa-hamburger"></i> Lunch: <span class="highlight">12:00 PM - 2:30 PM</span></li>
                <li><i class="fas fa-pizza-slice"></i> Dinner: <span class="highlight">7:00 PM - 9:30 PM</span></li>
            </ul>
            <p><strong class="highlight">Meal Schedule:</strong></p>
            <ul>
                <li><i class="fas fa-leaf"></i> Monday - Friday: <span class="highlight">Veg</span></li>
                <li><i class="fas fa-drumstick-bite"></i> Saturday - Sunday: <span class="highlight">Non-Veg</span></li>
                <li><i class="fas fa-star"></i> Holidays: <span class="highlight">Special Meals</span></li>
            </ul>
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
    <script>
        function hideAllSections() {
            document.querySelectorAll('.service-section').forEach(section => {
                section.style.display = 'none';
            });
        }
        document.getElementById('ordersBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('ordersSection').style.display = 'block'; });
        document.getElementById('homeDeliveryBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('homeDeliverySection').style.display = 'block'; });
        document.getElementById('parcelBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('parcelSection').style.display = 'block'; });
        document.getElementById('regularMessBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('regularMessSection').style.display = 'block'; });
        function hideAllSections() {
            document.querySelectorAll('.service-section').forEach(section => {
                section.style.display = 'none';
            });
        }
        document.getElementById('ordersBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('ordersSection').style.display = 'block'; });
        document.getElementById('homeDeliveryBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('homeDeliverySection').style.display = 'block'; });
        document.getElementById('parcelBtn').addEventListener('click', function() { hideAllSections(); document.getElementById('parcelSection').style.display = 'block'; });

        document.querySelectorAll('.order-btn').forEach(button => {
            button.addEventListener('click', function() {
                window.location.href = this.getAttribute('data-link');
            });
        });
    
    </script>
</body>
</html>