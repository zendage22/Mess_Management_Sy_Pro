<?php
session_start();
include 'conn.php';
// Redirect to login if the user is not logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}


include 'conn.php';
include 'attendance_section.php';
include 'mark_attendance.php';
include 'pur.php';
include 'orderse.php';
include 'manage_meal.php';
//include 'logout1.php';




// Fetch Meals Served Today
$mealQuery = "SELECT COUNT(*) AS meals_served FROM orders WHERE DATE(order_date) = CURDATE()";
$mealResult = $conn->query($mealQuery);
$mealsServed = ($mealResult && $mealResult->num_rows > 0) ? $mealResult->fetch_assoc()['meals_served'] : 0;

// Fetch Total Users
$userQuery = "SELECT COUNT(*) AS total_users FROM register";
$userResult = $conn->query($userQuery);
$totalUsers = ($userResult && $userResult->num_rows > 0) ? $userResult->fetch_assoc()['total_users'] : 0;

// **Ensure `$tableExists` is always defined**
$tableExists = false;

// Check if `payments` table exists
$checkPaymentsTable = "SHOW TABLES LIKE 'payments'";
$tableCheckResult = $conn->query($checkPaymentsTable);

if ($tableCheckResult && $tableCheckResult->num_rows > 0) {
    $tableExists = true; // Table exists
}

$plansQuery = "SELECT COUNT(*) AS total_plans FROM plans";
$plansResult = $conn->query($plansQuery);
$totalPlans = ($plansResult && $plansResult->num_rows > 0) ? $plansResult->fetch_assoc()['total_plans'] : 0;





// Fetch meals from the database
$mealQuery = "SELECT * FROM meal ORDER BY meal_id DESC";
$mealResult = $conn->query($mealQuery);


$sql = "SELECT * FROM user ORDER BY user_id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {


?>
   



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mess Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color:#e0f7fa; /* Light background color */
            transition: all 0.3s ease-in-out;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
        }



        #sidebar {
    width: 250px;
    position: fixed;
    height: 100vh; /* Full viewport height */
    top: 0;
    background-color: white;
    padding-top: 20px;
    transition: all 0.3s ease-in-out;
    overflow-y: auto; /* Enable scrolling */
    max-height: 100vh; /* Ensure it doesn't exceed viewport height */
}

/* Hide scrollbar in Webkit browsers */
#sidebar::-webkit-scrollbar {
    width: 8px;
}

#sidebar::-webkit-scrollbar-thumb {
    background-color: white;
    border-radius: 10px;
}


#sidebar .list-unstyled li a:hover {
            background-color: #495057;
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



        

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.1);
        }

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .form-control {
            border-radius: 5px;
        }

        .modal-footer .btn {
            background-color: #007bff;
            color: white;
        }

        .btn-success {
            background-color: white;
            
            
        }

        .container-fluid {
            padding-top: 20px;
        }

        @media (max-width: 768px) {
  .container {
    flex-direction: column;
  }

  



            #page-content-wrapper {
                margin-left: 0;
            }

            .navbar .btn {
                width: 100%;
            }

            .content {
                margin-top: 20px;
            }
        }

        .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      padding: 2rem;
    }

    .item {
      flex: 1 1 300px; 
      margin: 10px;
      background: lightgray;
      padding: 1rem;
    }

    @media (max-width: 768px) {
      .container {
        display: block;
      }
      .item {
        width: 100%;
      }
    }

    .dropdown-menu {
    /*display: block !important;*/
    position: absolute !important;
    background-color: #343a40; /* Dark background */
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
                <li><a href="#manage_meal" class="text-white"><i class="fas fa-chart-line"></i> manage_meal</a></li>

                <li><a href="#purchase-plan" class="text-white"><i class="fas fa-shopping-cart"></i> Purchase Plan</a></li>
            <li><a href="#orders" class="text-white"><i class="fas fa-box"></i> Orders</a></li>
            <li><a href="logout1.php"class="text-white"><i class="fas fa-sign-out-alt"></i> Logout</a></li>


               <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cogs"></i> Settings
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    <a class="dropdown-item" href="help.php"><i class="fas fa-question-circle"></i> Help</a>
                </div>
            </li>   -->              
           </ul>
        </div> 
   
        <!-- Page Content -->
        <div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>
    </nav>
    
    <div class="container-fluid">
        <div id="dashboard" class="content active">
            <h2>Dashboard</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-utensils"></i> Meals Served Today</h5>
                            <p id="meals-served" class="fs-3 fw-bold"><?= $mealsServed ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users"></i> Users</h5>
                            <p id="total-users" class="fs-3 fw-bold"><?= $totalUsers ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Total Purchased Plans</h5>
                            <p id="total-plans" class="fs-3 fw-bold"><?= $totalPlans ?></p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div> 
</div>
                <!-- Users Section -->
                <div id="users" class="content">
                    <h2>Manage Users</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">Add User</button>
                    <h4 class="mt-4">Existing Users</h4>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                            <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Mobile_NO</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php  
                     // Loop through and display each row
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['user_id']; ?></td>
                                <td><?php echo $row['user_name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['mobile']; ?></td>

                                <td>

                                    <a href="edit_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
 
                                    <a href="delete_user.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                                </td>
                                

                            </tr>
                        </tbody>
                     <?php   }
                    } else {
                        echo "No users found.";
                    }?>
                    </table>
                </div>

               <!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bg-primary" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action="add_user.php" method="POST">
                    <div class="mb-3">
                        <label for="userName" class="form-label">User Name</label>
                        <input type="text" class="form-control" id="userName" name="userName" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">User Email</label>
                        <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">User Role</label>
                        <select class="form-select" id="userRole" name="userRole" required>
                        <option value="#">Select</option>
                            <option value="student">Student</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userMobile_No" class="form-label">User Mobile_No</label>
                        <input type="tel" class="form-control" id="userMobile" name="userMobile" pattern="[0-9]{10}" required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="addUser">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


                <!-- Meals Section -->
                <div id="meals" class="content">
                    <h2>Manage Meal</h2>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMealModal">Add Meal</button>
                    <h4 class="mt-4">Existing Meal</h4>
                    <table class="table table-striped table-hover">       
            
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($meal = $mealResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $meal['meal_id']; ?></td>
                            <td><?php echo $meal['meal_name']; ?></td>
                            <td><?php echo $meal['meal_category']; ?></td>
                            <td><?php echo $meal['meal_price']; ?></td>
                            <td><img src="uploads/<?php echo $meal['meal_image']; ?>" width="50" height="50"></td>
                            <td>
                                <a href="edit_meal.php?meal_id=<?php echo $meal['meal_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_meal.php?meal_id=<?php echo $meal['meal_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
                



                <!-- Add Meal Modal -->
                

               <div class="modal fade" id="addMealModal" tabindex="-1" aria-labelledby="addMealModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bg-primary" id="addMealModalLabel">Add Meal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="add_meal.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="mealName" class="form-label">Meal Name</label>
        <input type="text" class="form-control" id="mealName" name="mealName" required>
    </div>
    <div class="mb-3">
        <label for="mealCategory" class="form-label">Meal Category</label>
        <input type="text" class="form-control" id="mealCategory" name="mealCategory" required>
    </div>
    <div class="mb-3">
        <label for="mealPrice" class="form-label">Meal Price</label>
        <input type="number" class="form-control" id="mealPrice" name="mealPrice" required>
    </div>
    <div class="mb-3">
        <label for="mealImage" class="form-label">Meal Image</label>
        <input type="file" class="form-control" id="mealImage" name="mealImage" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="addMeal">Add Meal</button>
    </div>
</form>


    


                <!-- order Section -->
                


            <!-- Purchase Plan Section -->
 <!-- Page Content -->
 

                <!-- Attendance Section -->

                




    



 



               
                <!-- Reports Section -->
               
            <div class="container-fluid">
                <!-- Reports Section -->
                <div id="reports" class="content">
                    <h2>Reports</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $index => $report) : ?>
                                <tr>
                                    <td><?= $report['title'] ?></td>
                                    <td><?= $report['date'] ?></td>
                                    <td><?= $report['description'] ?></td>
                                    <td>
                                        <a href="?download=<?= $index ?>" class="btn btn-success btn-sm">Download</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>





                
               


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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

    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }


    







    
//purchaseplan





    
    </script>

</body>
</html>
