<?php

include 'conn.php';

// Check if ID is set in the URL and valid
if (!isset($_GET['user_id']) || empty($_GET['user_id']) || !is_numeric($_GET['user_id'])) {
    echo "<script>alert('Invalid Request! User ID is missing.'); window.location.href='admin.php';</script>";
    exit();
}

$user_id = (int) $_GET['user_id']; // Ensure it's an integer

// Handle update form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $user_id = (int) $_POST['user_id']; 
    $userName = trim($_POST['userName']);
    $userEmail = trim($_POST['userEmail']);
    $userRole = trim($_POST['userRole']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("UPDATE user SET user_name = ?, email = ?, role = ? WHERE user_id = ?");
    $stmt->bind_param("sssi", $userName, $userEmail, $userRole, $user_id);

    if ($stmt->execute()) {
        echo "<script>
                    alert('updated Successfully');
                    window.location.href = 'admin.php';
              </script>";
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

// Fetch user details securely
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('User not found!'); window.location.href='admin.php';</script>";
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .form-title {
            font-weight: 600;
            color: #444;
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #764ba2;
            color: white;
            font-weight: 500;
            transition: 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background-color: #5b3a8a;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="form-container">
        <h3 class="form-title">Edit User Details</h3>
        
        <form action="" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="userName" class="form-control" value="<?php echo htmlspecialchars($row['user_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="userEmail" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="userRole" class="form-select">
                    <option value="Employee" <?php if ($row['role'] == "Employee") echo "selected"; ?>>Employee</option>
                    <option value="Student" <?php if ($row['role'] == "User") echo "selected"; ?>>Student</option>
                </select>
            </div>

            <button type="submit" name="update" class="btn btn-custom w-100">Update</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
