<?php
include 'conn.php';

if (isset($_GET['attendance_id'])) {
    $attendance_id = $_GET['attendance_id'];
    $query = "SELECT * FROM attendance WHERE attendance_id = '$attendance_id'";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
}

if (isset($_POST['updateAttendance'])) {
    $attendance_id = $_POST['attendance_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE attendance SET status='$status' WHERE attendance_id='$attendance_id'";
    if ($conn->query($updateQuery)) {
        echo "<script>alert('Attendance updated successfully!'); window.location.href='admin.php#attendance';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Compact & Centered Form -->
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg border-0" style="width: 320px;">
        <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Update Attendance</h5>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="attendance_id" value="<?php echo $row['attendance_id']; ?>">

                <div class="mb-3">
                    <label class="form-label"><strong>Status:</strong></label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="present" <?php if ($row['status'] == 'present') echo "selected"; ?>>Present</option>
                        <option value="absent" <?php if ($row['status'] == 'absent') echo "selected"; ?>>Absent</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="admin.php#attendance" class="btn btn-secondary btn-sm">Cancel</a>
                    <button type="submit" name="updateAttendance" class="btn btn-success btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
