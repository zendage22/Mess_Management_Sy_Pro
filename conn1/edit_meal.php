<?php
include 'conn.php';

// Ensure meal array is initialized
$meal = ['meal_name' => '', 'meal_category' => '', 'meal_price' => '', 'meal_image' => ''];

// Check if meal ID is provided and valid
if (!isset($_GET['meal_id']) || empty($_GET['meal_id']) || !is_numeric($_GET['meal_id'])) {
    echo "<script>alert('Invalid meal ID! Redirecting...'); window.location.href='admin.php';</script>";
    exit();
}

$mealId = intval($_GET['meal_id']); // Convert to integer for safety

// Fetch existing meal data using a prepared statement
$query = $conn->prepare("SELECT * FROM meal WHERE meal_id = ?");
$query->bind_param("i", $mealId);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $meal = $result->fetch_assoc();
} else {
    echo "<script>alert('Meal not found! Redirecting...'); window.location.href='admin.php';</script>";
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mealName = $_POST['mealName'] ?? '';
    $mealCategory = $_POST['mealCategory'] ?? '';
    $mealPrice = $_POST['mealPrice'] ?? '';

    // Validate inputs
    if (empty($mealName) || empty($mealCategory) || empty($mealPrice)) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        // Handle image upload
        if (!empty($_FILES["mealImage"]["name"])) {
            $targetDir = "uploads/";
            $fileName = basename($_FILES["mealImage"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allowed image types
            $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["mealImage"]["tmp_name"], $targetFilePath)) {
                    // Update query including image
                    $updateQuery = $conn->prepare("UPDATE meal SET meal_name=?, meal_category=?, meal_price=?, meal_image=? WHERE meal_id=?");
                    $updateQuery->bind_param("ssdsi", $mealName, $mealCategory, $mealPrice, $fileName, $mealId);
                } else {
                    echo "<script>alert('Error uploading image.');</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
                exit();
            }
        } else {
            // Update without changing the image
            $updateQuery = $conn->prepare("UPDATE meal SET meal_name=?, meal_category=?, meal_price=? WHERE meal_id=?");
            $updateQuery->bind_param("ssdi", $mealName, $mealCategory, $mealPrice, $mealId);
        }

        // Execute update query
        if ($updateQuery->execute()) {
            echo "<script>alert('Meal updated successfully!'); window.location.href='admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating meal: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('background.jpg') no-repeat center center/cover;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            font-family: 'Poppins', sans-serif;
        }
        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
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
            background-color: #ff758c;
            color: white;
            font-weight: 500;
            transition: 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background-color: #e84560;
        }
        .form-control:focus, .form-select:focus {
            border-color: #ff758c;
            box-shadow: 0 0 8px rgba(255, 117, 140, 0.6);
        }
        .meal-img {
            display: block;
            margin: 10px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="form-container">
            <h3 class="form-title">Edit Meal</h3>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="meal_id" value="<?= $mealId; ?>">
                
                <div class="mb-3">
                    <label class="form-label">Meal Name:</label>
                    <input type="text" name="mealName" class="form-control" value="<?= htmlspecialchars($meal['meal_name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meal Category:</label>
                    <input type="text" name="mealCategory" class="form-control" value="<?= htmlspecialchars($meal['meal_category']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meal Price:</label>
                    <input type="number" name="mealPrice" class="form-control" value="<?= htmlspecialchars($meal['meal_price']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meal Image:</label>
                    <input type="file" name="mealImage" class="form-control">
                    <?php if (!empty($meal['meal_image'])): ?>
                        <p class="mt-2 text-center">Current Image:</p>
                        <img src="uploads/<?= htmlspecialchars($meal['meal_image']); ?>" width="100" class="meal-img" alt="Meal Image">
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-custom w-100">Update Meal</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const formContainer = document.querySelector(".form-container");
            formContainer.style.opacity = "0";
            setTimeout(() => {
                formContainer.style.opacity = "1";
            }, 200);
        });
    </script>
</body>
</html>
