<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard - Mess Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }

        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #28a745;
            padding-top: 20px;
            position: fixed;
            transition: all 0.3s ease;
        }

        #sidebar .list-unstyled li {
            margin-bottom: 15px;
        }

        #sidebar .list-unstyled li a {
            color: white;
            font-size: 18px;
            text-decoration: none;
            padding: 12px;
            display: block;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #sidebar .list-unstyled li a:hover {
            background-color: #218838;
        }

        #page-content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            padding: 15px 20px;
            background-color: #007bff;
        }

        .navbar .btn {
            background-color: #f39c12;
            color: white;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            text-align: center;
        }

        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .container-fluid {
            margin-top: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 200px;
            }

            #page-content-wrapper {
                margin-left: 0;
            }

            .navbar .btn {
                width: 100%;
            }

            .card {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar" class="bg-success text-white p-3">
            <h2 class="text-center">Staff Panel</h2>
            <ul class="list-unstyled">
                <li><a href="#dashboard" class="text-white"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#meals" class="text-white"><i class="fas fa-utensils"></i> Meals</a></li>
                <li><a href="#attendance" class="text-white"><i class="fas fa-calendar-check"></i> Attendance</a></li>
                <li><a href="#reports" class="text-white"><i class="fas fa-chart-line"></i> Reports</a></li>
            </ul>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="btn btn-warning" id="menu-toggle"><i class="fas fa-bars"></i> Menu</button>
                <button class="btn btn-danger ms-auto" onclick="window.location.href='logout.php'">Logout</button>
            </nav>

            <div class="container-fluid">
                <!-- Dashboard -->
                <div id="dashboard" class="content active">
                    <h2>Dashboard</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Meals Served Today</h5>
                                    <p id="meals-served">150</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Attendance Recorded</h5>
                                    <p id="attendance-recorded">80</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Requests</h5>
                                    <p id="pending-requests">5</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Meals Section -->
                <div id="meals" class="content">
                    <h2>Manage Meals</h2>
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMealModal">Add Meal</button>
                    <h4 class="mt-4">Available Meals</h4>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Meal Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vegetable Soup</td>
                                <td>Vegetarian</td>
                                <td>$5</td>
                                <td><button class="btn btn-danger btn-sm">Delete</button></td>
                            </tr>
                            <tr>
                                <td>Chicken Biryani</td>
                                <td>Non-Vegetarian</td>
                                <td>$10</td>
                                <td><button class="btn btn-danger btn-sm">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Attendance Section -->
                <div id="attendance" class="content">
                    <h2>Attendance</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2025-02-10</td>
                                <td>John Doe</td>
                                <td>Present</td>
                            </tr>
                            <tr>
                                <td>2025-02-10</td>
                                <td>Jane Smith</td>
                                <td>Absent</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Reports Section -->
                <div id="reports" class="content">
                    <h2>Reports</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Monthly Report</td>
                                <td>2025-01-31</td>
                                <td>Summary of January meals and attendance</td>
                            </tr>
                            <tr>
                                <td>Annual Report</td>
                                <td>2025-12-31</td>
                                <td>Annual overview of Mess Management</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer Section -->
    <footer class="footer">
        <p>&copy; 2025 Mess Management System | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar visibility
        document.getElementById("menu-toggle").addEventListener("click", function () {
            var sidebar = document.getElementById("sidebar");
            var content = document.getElementById("page-content-wrapper");
            sidebar.classList.toggle("d-none");
            content.classList.toggle("ml-3");
        });

        // Show content based on navigation
        const links = document.querySelectorAll("ul li a");
        links.forEach(link => {
            link.addEventListener("click", function () {
                const target = document.querySelector(link.getAttribute("href"));
                const sections = document.querySelectorAll(".content");
                sections.forEach(section => section.classList.remove("active"));
                target.classList.add("active");
            });
        });
    </script>
</body>
</html>
