<?php
session_start();
include 'conn.php';
// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mess_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT user_id, fname, email FROM register WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch attendance data
$sql_attendance = "SELECT date, status FROM attendance WHERE user_id = ? ORDER BY date DESC";
$stmt_attendance = $conn->prepare($sql_attendance);
$stmt_attendance->bind_param("i", $user_id);
$stmt_attendance->execute();
$attendance_result = $stmt_attendance->get_result();






// Insert into the database








// Fetch user details
$user_query = $conn->prepare("SELECT * FROM register WHERE user_id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();
$user_query->close();

// Fetch attendance records
$attendance_query = $conn->prepare("SELECT date, status FROM attendance WHERE user_id = ? ORDER BY date DESC");
$attendance_query->bind_param("i", $user_id);
$attendance_query->execute();
$attendance_result = $attendance_query->get_result();
$attendance_data = $attendance_result->fetch_all(MYSQLI_ASSOC);
$attendance_query->close();

// Fetch purchased plans
$plans_query = $conn->prepare("SELECT * FROM plans WHERE user_id = ? ORDER BY purchase_date DESC");
$plans_query->bind_param("i", $user_id);
$plans_query->execute();
$plans_result = $plans_query->get_result();
$plans_query->close();

// Fetch payment details
$payments_query = $conn->prepare("SELECT * FROM payments WHERE user_id = ? ORDER BY payment_date DESC");
$payments_query->bind_param("i", $user_id);
$payments_query->execute();
$payments_result = $payments_query->get_result();
$payments_query->close();


// Handle Purchase Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['purchase'])) {
    $plan_name = isset($_POST['plan']) ? $_POST['plan'] : null;
    $plan_price = isset($_POST['price']) ? $_POST['price'] : null;

    // Debugging to check values before inserting into DB
    if (empty($plan_name) || empty($plan_price)) {
        die("Error: Plan name or price is missing.");
    }

    // Insert purchase into database
    $stmt = $conn->prepare("INSERT INTO plans (user_id, plan_name, price, purchase_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("isd", $user_id, $plan_name, $plan_price);

    if ($stmt->execute()) {
        echo "<script>alert('✅ $plan_name purchased successfully!'); window.location.href='user_dash.php';</script>";
    } else {
        echo "<script>alert('❌ Error purchasing plan!');</script>";
    }
    $stmt->close();
}
// Handle Payment Processing
// Handle Payment Submission


$latest_plan = null; // Ensure it's always defined

if ($conn) {
    $latest_plan_query = $conn->prepare("SELECT id, plan_name, price FROM plans WHERE user_id = ? ORDER BY purchase_date DESC LIMIT 1");
    if ($latest_plan_query) {
        $latest_plan_query->bind_param("i", $user_id);
        $latest_plan_query->execute();
        $latest_plan_result = $latest_plan_query->get_result();
        $latest_plan = $latest_plan_result->fetch_assoc();
        $latest_plan_query->close();
    }
}

// Debugging: Check if plan_id is fetched
$latest_plan = null; // Ensure it's always defined

if ($conn) {
    $latest_plan_query = $conn->prepare("SELECT id, plan_name, price FROM plans WHERE user_id = ? ORDER BY purchase_date DESC LIMIT 1");
    if ($latest_plan_query) {
        $latest_plan_query->bind_param("i", $user_id);
        $latest_plan_query->execute();
        $latest_plan_result = $latest_plan_query->get_result();
        $latest_plan = $latest_plan_result->fetch_assoc();
        $latest_plan_query->close();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_now'])) {
    $payment_plan_id = $_POST['plan_id'];
    $payment_amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    if (empty($payment_plan_id) || empty($payment_amount) || empty($payment_method)) {
        die("<script>alert('❌ Error: Payment details are missing.'); window.location.href='user_dash.php';</script>");
    }

    // Insert payment into database
    $payment_stmt = $conn->prepare("INSERT INTO payments (user_id, plan_id, amount, payment_status, payment_method, payment_date) VALUES (?, ?, ?, 'Success', ?, NOW())");
    $payment_stmt->bind_param("iids", $user_id, $payment_plan_id, $payment_amount, $payment_method);

    if ($payment_stmt->execute()) {
        echo "<script>alert('✅ Payment successful!'); window.location.href='user_dash.php';</script>";
    } else {
        echo "<script>alert('❌ Error processing payment!');</script>";
    }
    $payment_stmt->close();
}






// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            cursor: pointer;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .content-section {
            display: none;
        }
        .content-section.active {
            display: block;
        }
    </style>
</head>
<body>

   <!-- Sidebar -->
<div class="sidebar bg-dark p-3 vh-100 text-white">
    <h4 class="text-center fw-bold">📊 Dashboard</h4>
    <hr class="border-light">
    <a class="nav-link active text-light fw-bold py-2" onclick="showSection('home')"><i class="fas fa-home"></i> Home</a>
    <a class="nav-link text-light fw-bold py-2" onclick="showSection('attendance')"><i class="fas fa-user-check"></i> Attendance</a>
    <a class="nav-link text-light fw-bold py-2" onclick="showSection('purchase')"><i class="fas fa-concierge-bell"></i> Purchase Plan</a>
    <a class="nav-link text-light fw-bold py-2" onclick="showSection('payment')"><i class="fas fa-credit-card"></i> Payment</a>
    <a class="nav-link text-light fw-bold py-2" onclick="showSection('profile')"><i class="fas fa-user"></i> Profile</a>
    <a href="logout.php" class="nav-link text-danger fw-bold py-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

  <!-- Main Content -->
  <div class="main-content">

<!-- Home Section -->
<div id="home" class="content-section active">
    <h2>Welcome, <?php echo htmlspecialchars($user['fname']); ?>!</h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['user_id']); ?></p>
</div>

        <!-- Attendance Section -->
        <div id="attendance" class="content-section p-4">
    <div class="card shadow-lg rounded-4 p-4">
        <h3 class="text-center text-primary fw-bold">📅 Your Attendance</h3>
        
        <!-- Select Month -->
        <div class="mb-4">
            <label class="fw-bold text-secondary">📆 Select Month:</label>
            <input type="month" id="month" class="form-control border-2 shadow-sm rounded-3" required>
        </div>

        <!-- Fetch Attendance Button -->
        <div class="text-center mb-4">
            <button class="btn btn-primary fw-bold px-4 py-2 shadow-lg rounded-3 transition" onclick="fetchAttendance()">
                ✅ Fetch Attendance
            </button>
        </div>

        <!-- Attendance Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="attendance_table">
                    <?php while ($row = $attendance_result->fetch_assoc()) { ?>
                        <tr class="fw-bold">
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td>
                                <?php
                                    $status = htmlspecialchars($row['status']);
                                    $status_class = ($status === "Present") ? "text-success fw-bold" :
                                                    (($status === "Absent") ? "text-danger fw-bold" : "text-warning fw-bold");
                                ?>
                                <span class="<?php echo $status_class; ?>">
                                    <?php echo $status; ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CSS for Styling --><!--Purchase_plan-->


<!-- Purchase Plan Section -->
<!-- Purchase Plan Section -->
<div class="content-section p-4" id="purchase">
    <h2 class="text-center text-primary fw-bold">🍽️ Choose Your Meal Plan</h2>
    
    <div class="row">
        <!-- Basic Plan -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="fw-bold text-secondary">Basic Plan</h5>
                <p class="fw-bold">₹1000/month</p>
                <form method="POST" action="user_dash.php">
                    <input type="hidden" name="plan" value="Basic Plan">
                    <input type="hidden" name="price" value="1000">
                    <button type="submit" name="purchase" class="btn btn-primary fw-bold">Buy Now</button>
                </form>
            </div>
        </div>

        <!-- Standard Plan -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="fw-bold text-secondary">Standard Plan</h5>
                <p class="fw-bold">₹1500/month</p>
                <form method="POST" action="user_dash.php">
                    <input type="hidden" name="plan" value="Standard Plan">
                    <input type="hidden" name="price" value="1500">
                    <button type="submit" name="purchase" class="btn btn-success fw-bold">Buy Now</button>
                </form>
            </div>
        </div>

        <!-- Premium Plan -->
        <div class="col-md-4">
            <div class="card p-3 shadow">
                <h5 class="fw-bold text-warning">Premium Plan</h5>
                <p class="fw-bold">₹2000/month</p>
                <form method="POST" action="user_dash.php">
                    <input type="hidden" name="plan" value="Premium Plan">
                    <input type="hidden" name="price" value="2000">
                    <button type="submit" name="purchase" class="btn btn-warning fw-bold">Buy Now</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Plan History Section -->
    <h3 class="mt-5 text-info fw-bold">📜 Your Plan History</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-info">
                <tr>
                    <th>📌 Plan Name</th>
                    <th>💰 Price</th>
                    <th>📅 Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($plan = $plans_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($plan['plan_name']); ?></td>
                        <td class="fw-bold text-success">₹<?php echo htmlspecialchars($plan['price']); ?></td>
                        <td><?php echo htmlspecialchars($plan['purchase_date']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Payment Section -->

<div class="content-section p-4" id="payment">
        <h2 class="text-center text-primary fw-bold">💳 Payment Section</h2>

        <!-- Display Latest Purchased Plan -->
        <h4 class="mt-4 text-success fw-bold">🛍️ Current Purchased Plan</h4>
        <?php if ($latest_plan) { ?>
            <div class="card p-3 shadow-lg">
                <h5 class="fw-bold text-secondary">Plan: <?php echo htmlspecialchars($latest_plan['plan_name']); ?></h5>
                <p class="fw-bold text-success">Price: ₹<?php echo htmlspecialchars($latest_plan['price']); ?></p>

                <!-- Payment Form -->
                <form method="POST" action="user_dash.php">
                    <input type="hidden" name="plan_id" value="<?php echo htmlspecialchars($latest_plan['id']); ?>">
                    <input type="hidden" name="amount" value="<?php echo htmlspecialchars($latest_plan['price']); ?>">

                    <label class="fw-bold">Select Payment Method:</label>
                    <select name="payment_method" class="form-control mb-3" required>
                        <option value="Credit Card">💳 Credit Card</option>
                        <option value="Debit Card">🏦 Debit Card</option>
                        <option value="UPI">📲 UPI</option>
                        <option value="Net Banking">💻 Net Banking</option>
                    </select>

                    <button type="submit" name="pay_now" class="btn btn-primary fw-bold">🔄 Pay Now</button>
                </form>
            </div>
        <?php } else {
            echo "<p class='text-muted'>No purchased plans found.</p>";
        } ?>

        <!-- Payment History -->
        <h3 class="mt-4 text-warning fw-bold">📜 Payment History</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover shadow-sm">
                <thead class="table-warning">
                    <tr>
                        <th>💰 Amount</th>
                        <th>📅 Payment Date</th>
                        <th>✅ Status</th>
                        <th>🗑️ Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($payment = $payments_result->fetch_assoc()) { ?>
                        <tr>
                            <td class="fw-bold text-primary">₹<?php echo htmlspecialchars($payment['amount']); ?></td>
                            <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                            <td class="fw-bold <?php echo ($payment['payment_status'] == 'Success') ? 'text-success' : 'text-danger'; ?>">
                                <?php echo htmlspecialchars($payment['payment_status']); ?>
                            </td>
                            <td>
                                <form method="POST" action="delete_payment.php">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Payment Section -->




        <!-- Profile Section -->
<!-- Profile Section -->
<<div class="content-section p-4" id="profile">
    <div class="row justify-content-center">
        <!-- Profile Content -->
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-lg border-0 rounded-3 p-4 bg-white">
                <h4 class="text-center text-primary fw-bold">👤 User Profile</h4>
                
                <!-- User Info -->
                <div class="d-flex align-items-center justify-content-center flex-column">
                    <div class="bg-primary text-white p-3 rounded-circle mb-3">
                        <i class="fas fa-user fa-2x"></i>
                    </div>
                    <h5 class="fw-bold">📝 Name: <span class="text-dark"><?php echo htmlspecialchars($user['fname']); ?></span></h5>
                    <h6 class="fw-bold">📧 Email: <span class="text-secondary"><?php echo htmlspecialchars($user['email']); ?></span></h6>
                </div>
            </div>

            <!-- Attendance Section -->
            <div class="card mt-3 shadow-lg border-0 rounded-3 p-3 bg-light">
                <h5 class="text-success fw-bold mb-2">📅 Attendance Records</h5>
                <?php if (!empty($attendance_data)) { ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover rounded-3 shadow-sm fs-6">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>📆 Date</th>
                                <th>✅ Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($attendance_data as $attendance) { ?>
                                <tr class="text-center">
                                    <td><?php echo htmlspecialchars($attendance['date']); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($attendance['status'] == 'Present') ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo htmlspecialchars($attendance['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { echo "<p class='text-muted text-center'>No attendance records found.</p>"; } ?>
            </div>

            <!-- Purchased Plans -->
            <div class="card mt-3 shadow-lg border-0 rounded-3 p-3 bg-white">
                <h5 class="text-info fw-bold mb-2">🛒 Purchased Plans</h5>
                <?php if ($plans_result->num_rows > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover rounded-3 shadow-sm fs-6">
                        <thead class="table-info text-center">
                            <tr>
                                <th>📌 Plan</th>
                                <th>💰 Price</th>
                                <th>📅 Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $plans_result->data_seek(0);
                            while ($plan = $plans_result->fetch_assoc()) { ?>
                                <tr class="text-center">
                                    <td class="fw-bold"><i class="fas fa-utensils"></i> <?php echo htmlspecialchars($plan['plan_name']); ?></td>
                                    <td class="fw-bold text-success">₹<?php echo htmlspecialchars($plan['price']); ?></td>
                                    <td><?php echo htmlspecialchars($plan['purchase_date']); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { echo "<p class='text-muted text-center'>No plans purchased yet.</p>"; } ?>
            </div>

            <!-- Payment History -->
            <div class="card mt-3 shadow-lg border-0 rounded-3 p-3 bg-light">
                <h5 class="text-warning fw-bold mb-2">💳 Payment History</h5>
                <?php if ($payments_result->num_rows > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover rounded-3 shadow-sm fs-6">
                        <thead class="table-warning text-center">
                            <tr>
                                <th>💵 Amount</th>
                                <th>✅ Status</th>
                                <th>📅 Date</th>
                                <th>🗑️ Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $payments_result->data_seek(0);
                            while ($payment = $payments_result->fetch_assoc()) { ?>
                                <tr class="text-center">
                                    <td class="fw-bold text-primary">₹<?php echo htmlspecialchars($payment['amount']); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($payment['payment_status'] == 'Success') ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo htmlspecialchars($payment['payment_status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                    <td>
                                        <form method="POST" action="delete_payment.php">
                                            <input type="hidden" name="payment_id" value="<?php echo $payment['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Delete this record?');">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { echo "<p class='text-muted text-center'>No payments found.</p>"; } ?>
            </div>
        </div>
    </div>
</div>


    <!-- JavaScript for AJAX and Navigation -->
    <script>
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.content-section').forEach(sec => {
                sec.classList.remove('active');
            });

            // Remove active class from all sidebar links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('active');
            });

            // Show the selected section
            document.getElementById(section).classList.add('active');

            // Highlight the selected sidebar link
            event.target.classList.add('active');
        }

        function fetchAttendance() {
            var month = document.getElementById('month').value;
            if (month === '') {
                alert('Please select a month.');
                return;
            }

            $.ajax({
                url: 'fetch_attendance.php',
                type: 'POST',
                data: { month: month },
                success: function(response) {
                    $('#attendance_table').html(response);
                }
            });
        }

        function showSection(section) {
        document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(section).classList.add('active');
    }

    function showSection(section) {
        document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
        document.getElementById(section).classList.add('active');
    }



        
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
