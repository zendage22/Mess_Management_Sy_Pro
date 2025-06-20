<?php





include 'conn.php';

// Check if database connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch users who have purchased plans
$sql = "SELECT register.user_id, register.fname, register.email, plans.plan_name, plans.purchase_date 
        FROM plans 
        INNER JOIN register ON plans.user_id = register.user_id
        ORDER BY plans.purchase_date DESC";
$result = $conn->query($sql);

// Check if query executes successfully
if (!$result) {
    die("Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchased Plans - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }
        
        .card-custom {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            font-size: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
            transition: 0.3s;
        }

        .badge-plan {
            font-size: 0.9rem;
            padding: 8px;
            border-radius: 5px;
        }

        .title-icon {
            font-size: 1.8rem;
            margin-right: 10px;
            color: #007bff;
        }

        .alert-custom {
            font-size: 1.1rem;
            padding: 15px;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div id="purchase-plan" class="content">
    <div class="card card-custom">
        <h2 class="text-center text-primary">
            <i class="fas fa-file-invoice-dollar title-icon"></i> Purchased Plans - Admin View
        </h2>

        <?php if ($result->num_rows > 0) { ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover mt-4">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-user"></i> User ID</th>
                            <th><i class="fas fa-user-circle"></i> Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-file-alt"></i> Plan Name</th>
                            <th><i class="fas fa-calendar-alt"></i> Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td>
                                    <span class="badge badge-plan bg-info text-dark">
                                        <?php echo htmlspecialchars($row['plan_name']); ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } else { ?>
            <div class="alert alert-warning text-center alert-custom">
                <i class="fas fa-exclamation-triangle"></i> No purchases found.
            </div>
        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
