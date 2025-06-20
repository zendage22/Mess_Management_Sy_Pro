<?php


// Handle Meal Insertion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_meal'])) {
    $meal_id = "MEAL_" . uniqid(); // Generate a unique meal ID
    $day = $_POST['day'];
    $meal_type = $_POST['meal_type'];
    $item_name = $_POST['item_name'];

    // Handle Image Upload
    $image = $_FILES['meal_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["meal_image"]["name"]);
    move_uploaded_file($_FILES["meal_image"]["tmp_name"], $target_file);

    // Insert meal into database
    $stmt = $conn->prepare("INSERT INTO meals (d, day, meal_type, item_name, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $day, $meal_type, $item_name, $target_file);

    if ($stmt->execute()) {
        echo "<script>alert('Meal added successfully!'); window.location='meal_manage.php';</script>";
    } else {
        echo "<script>alert('Error adding meal!');</script>";
    }
    $stmt->close();
}

// Handle Meal Deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM meals WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Meal deleted successfully!'); window.location='meal_manage.php';</script>";
}

// Fetch all meals from database
$result = $conn->query("SELECT * FROM meals ORDER BY day, meal_type");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Meals - Mess Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center text-primary">Manage Meals</h2>

    <!-- Meal Form -->
    <div class="card p-4 shadow">
        <h4 class="text-secondary">Add a New Meal</h4>
        <form method="POST" enctype="multipart/form-data">
            <label class="fw-bold">Select Day:</label>
            <select name="day" class="form-control mb-2" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>

            <label class="fw-bold">Meal Type:</label>
            <select name="meal_type" class="form-control mb-2" required>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>

            <label class="fw-bold">Meal Name:</label>
            <input type="text" name="meal_name" class="form-control mb-2" required>

            <label class="fw-bold">Upload Image:</label>
            <input type="file" name="meal_image" class="form-control mb-3" required>

            <button type="submit" name="add_meal" class="btn btn-success">Add Meal</button>
        </form>
    </div>

    <!-- Meal List -->
    <h3 class="mt-4 text-primary">Current Meals</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Meal ID</th>
                <th>Day</th>
                <th>Meal Type</th>
                <th>Meal Name</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['meal_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['day']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($row['meal_type'])); ?></td>
                    <td><?php echo htmlspecialchars($row['meal_name']); ?></td>
                    <td><img src="<?php echo $row['meal_image']; ?>" width="80"></td>
                    <td>
                        <a href="meal_manage.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
