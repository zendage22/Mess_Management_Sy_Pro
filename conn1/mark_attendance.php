<?php
include 'conn.php';

// Ensure form is submitted correctly
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if date is set and not empty
    if (isset($_POST['attendance_date']) && !empty($_POST['attendance_date'])) {
        $selected_date = $_POST['attendance_date']; // Get the selected date

        // Prevent future dates
        if ($selected_date > date("Y-m-d")) {
            echo "<script>alert('You cannot mark attendance for future dates!'); window.location.href='admin_dashboard.php#attendance';</script>";
            exit();
        }

        // Check if attendance array exists
        if (isset($_POST['attendance']) && is_array($_POST['attendance'])) {
            foreach ($_POST['attendance'] as $user_id => $status) {
                // Check if attendance is already marked for the selected date
                $check_query = "SELECT id FROM attendance WHERE user_id = ? AND date = ?";
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
    } else {
        echo "<script>alert('Please select a date.'); window.location.href='admin_dashboard.php#attendance';</script>";
    }
}
?>
