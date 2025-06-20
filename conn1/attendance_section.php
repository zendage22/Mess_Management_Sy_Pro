<?php
include 'conn.php';

// Fetch registered users
$sql_users = "SELECT user_id, email FROM register";
$result_users = $conn->query($sql_users);

// Check if query executed successfully
if (!$result_users) {
    die("Error fetching users: " . $conn->error); // Show error message if query fails
}

// Handle attendance form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_date = $_POST['attendance_date'] ?? null; // Check if attendance_date exists

    // Ensure a date is selected before processing
    if (!$selected_date) {
        echo "<script>alert('Please select a date.'); window.location.href='admin_dashboard.php#attendance';</script>";
        exit();
    }

    // Prevent marking attendance for future dates
    if ($selected_date > date("Y-m-d")) {
        echo "<script>alert('You cannot mark attendance for future dates!'); window.location.href='admin_dashboard.php#attendance';</script>";
        exit();
    }

    if (!empty($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $user_id => $status) {
            // Check if attendance already exists for this user on the selected date
            $check_query = "SELECT attendance_id FROM attendance WHERE user_id = ? AND date = ?";
            $stmt_check = $conn->prepare($check_query);
            $stmt_check->bind_param("is", $user_id, $selected_date);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows == 0) {
                // Insert attendance record
                $insert_query = "INSERT INTO attendance (user_id, date, status) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($insert_query);
                $stmt_insert->bind_param("iss", $user_id, $selected_date, $status);
                $stmt_insert->execute();
            } else {
                echo "<script>alert('Attendance for user ID $user_id on $selected_date is already marked!');</script>";
            }
        }
        echo "<script>alert('Attendance marked successfully!'); window.location.href='admin_dashboard.php#attendance';</script>";
    } else {
        echo "<script>alert('No users selected for attendance.'); window.location.href='admin_dashboard.php#attendance';</script>";
    }
}
?>

<!-- Attendance Section -->
<div id="attendance" class="content p-4">
    <h2 class="text-center text-white mb-4">📅 Mark Attendance</h2>
    <form method="POST" action="attendance_section.php" class="p-4 bg-white shadow-lg rounded-4">
        
        <!-- Date Selection -->
        <div class="mb-3">
            <label class="fw-bold text-primary">📆 Select Date:</label>
            <input type="date" name="attendance_date" class="form-control border-2 shadow-sm p-2 rounded-3" required>
        </div>

        <!-- Table with User Details -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $result_users->fetch_assoc()) { ?>
                        <tr class="fw-bold">
                            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <select name="attendance[<?php echo $user['user_id']; ?>]" class="form-select border-2 shadow-sm rounded-3">
                                    <option value="Present" class="text-success">✅ Present</option>
                                    <option value="Absent" class="text-danger">❌ Absent</option>
                                    <option value="Late" class="text-warning">⏳ Late</option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-lg rounded-3 transition">
                ✅ Submit Attendance
            </button>
        </div>

    </form>
</div>

<!-- CSS Styling -->
<style>
    /* Background */
    body {
        background: linear-gradient(135deg,rgb(183, 240, 192),rgb(209, 245, 206));
        font-family: 'Poppins', sans-serif;
    }

    /* Container */
    .content {
        max-width: 900px;
        margin: auto;
        margin-top: 50px;
        border-radius: 15px;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* Form Styling */
    .form-control, .form-select {
        transition: all 0.3s ease-in-out;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
    }

    /* Button Styling */
    .btn-primary {
        font-size: 18px;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: scale(1.05);
        background-color:rgb(231, 147, 68);
    }

    /* Table Styling */
    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead {
        background: #212529;
        color: white;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    /* Transition Animation */
    .transition {
        transition: all 0.3s ease-in-out;
    }
</style>
