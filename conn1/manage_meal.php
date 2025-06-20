<?php
include 'conn.php'; // Include database connection

// Check if update request is submitted
if (isset($_POST['updateMeal'])) {
    $id = $_POST['id'];
    $day = $_POST['day'];
    $meal_type = $_POST['meal_type'];
    $item_name = $_POST['item_name'];
    
    // Check if a new image is uploaded
    if (!empty($_FILES['meal_image']['name'])) {
        $image_path = "uploads/" . basename($_FILES['meal_image']['name']);
        move_uploaded_file($_FILES['meal_image']['tmp_name'], $image_path);
        $sql = "UPDATE menu SET day='$day', meal_type='$meal_type', item_name='$item_name', image_path='$image_path' WHERE id=$id";
    } else {
        $sql = "UPDATE menu SET day='$day', meal_type='$meal_type', item_name='$item_name' WHERE id=$id";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('Meal updated successfully!'); window.location='manage_meal.php';</script>";
    } else {
        echo "<script>alert('Error updating meal: " . $conn->error . "');</script>";
    }
}

// Fetch all menu items
$sql = "SELECT * FROM menu";
$result = $conn->query($sql);

// Fetch meal details if editing
$editMeal = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM menu WHERE id=$edit_id");
    $editMeal = $editResult->fetch_assoc();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: 'Poppins', sans-serif; }
        .content { max-width: 900px; margin-top: 30px; }
        .card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            margin: auto;
            width: 100%;
        }        table { margin: 0 auto; }
        table img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
        .btn { transition: 0.3s; font-weight: 500; }
        .btn:hover { transform: scale(1.05); }
        .table th { background-color: #343a40; color: #fff; }
        .form-label { font-weight: 600; }
    </style>
</head>
<body>
<div id="manage_meal" class="content">
        <div class="card p-4">
            <h2 class="text-center text-dark fw-bold">Meal Menu Management</h2>
            
            <?php if ($editMeal): ?>
            <h4 class="mt-3 text-secondary">Edit Meal</h4>
            <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
                <input type="hidden" name="id" value="<?= $editMeal['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Select Day:</label>
                    <select name="day" class="form-select" required>
                        <option value="monday" <?= $editMeal['day'] == 'monday' ? 'selected' : '' ?>>Monday</option>
                        <option value="tuesday" <?= $editMeal['day'] == 'tuesday' ? 'selected' : '' ?>>Tuesday</option>
                        <option value="wednesday" <?= $editMeal['day'] == 'wednesday' ? 'selected' : '' ?>>Wednesday</option>
                        <option value="thursday" <?= $editMeal['day'] == 'thursday' ? 'selected' : '' ?>>Thursday</option>
                        <option value="friday" <?= $editMeal['day'] == 'friday' ? 'selected' : '' ?>>Friday</option>
                        <option value="saturday" <?= $editMeal['day'] == 'saturday' ? 'selected' : '' ?>>Saturday</option>
                        <option value="sunday" <?= $editMeal['day'] == 'sunday' ? 'selected' : '' ?>>Sunday</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Meal Type:</label>
                    <select name="meal_type" class="form-select" required>
                        <option value="breakfast" <?= $editMeal['meal_type'] == 'breakfast' ? 'selected' : '' ?>>Breakfast</option>
                        <option value="lunch" <?= $editMeal['meal_type'] == 'lunch' ? 'selected' : '' ?>>Lunch</option>
                        <option value="dinner" <?= $editMeal['meal_type'] == 'dinner' ? 'selected' : '' ?>>Dinner</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Meal Name:</label>
                    <input type="text" name="item_name" class="form-control" value="<?= $editMeal['item_name'] ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Current Image:</label><br>
                    <img src="<?= $editMeal['image_path'] ?>" class="rounded shadow" width="100">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Upload New Image (Optional):</label>
                    <input type="file" name="meal_image" class="form-control">
                </div>
                
                <button type="submit" name="updateMeal" class="btn btn-dark">Update Meal</button>
                <a href="menu.php" class="btn btn-outline-secondary">Cancel</a>
            </form>
            <?php endif; ?>
            
            <table class="table table-bordered text-center mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Day</th>
                        <th>Meal Type</th>
                        <th>Meal Name</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row["id"] ?></td>
                                <td><?= ucfirst($row["day"]) ?></td>
                                <td><?= ucfirst($row["meal_type"]) ?></td>
                                <td><?= $row["item_name"] ?></td>
                                <td><img src="<?= $row["image_path"] ?>" alt="Meal Image"></td>
                                <td>
                                    <a href='manage_meal.php?edit=<?= $row["id"] ?>' class='btn btn-warning btn-sm'>Edit</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan='6' class='text-danger'>No menu items found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
