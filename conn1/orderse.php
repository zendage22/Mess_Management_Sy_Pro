<?php
include 'conn.php';

// Fetch orders from database
$sqlOrders = "SELECT * FROM orders ORDER BY order_id ASC";
$orderResult = $conn->query($sqlOrders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mess Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        #wrapper {
            display: flex;
            min-height: 100vh;
        }
       
       
        
        #page-content-wrapper {
            margin-left: 250px;
            width: 100%;
            padding: 20px;
        }
        .content {
            display:none;
        }
        .content.active {
            display: block;
        }
        .table th, .table td {
            text-align: center;
        }

        .table thead {
            background-color:rgb(130, 162, 193) !important; /* Darker Blue */
            color: white !important; /* White Text */
            font-size: 16px;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 1;
        }

.table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .badge {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 15px;
        }

        .btn-sm {
            padding: 5px 12px;
            font-size: 14px;
        }
        .card {
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* ✅ Adds soft shadow */
    background: white;
}

.table-responsive {
    max-height: 500px; /* ✅ Prevents table from expanding too much */
    overflow-y: auto; /* ✅ Adds scroll if necessary */
}

    </style>
</head>
<body>
 

                <!-- Orders Section -->
                <div id="orders" class="content">
    <h2 class="text-center mb-4">
        <i class="fas fa-shopping-cart "></i> Order Management
    </h2>

    <!-- ✅ Wrapped inside a Bootstrap Card -->
    <div class="card shadow-lg rounded">
        <div class="card-body">
            <div class="table-responsive"> <!-- ✅ Ensures table fits properly -->
                <table class="table table-bordered table-hover text-center">
                    <thead class="bg-primary text-white fw-bold">
                    <tr>
                        <th>Order ID</th>
                        <th>Name</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Address</th> <!-- ✅ New Address Column -->

                        <th>Menu Items</th>
                        <th>Total (₹)</th>
                        <th>Payment Mode</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orderResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $order['order_id']; ?></td>
                            <td><?= $order['name']; ?></td>
                            <td><?= $order['phone_no']; ?></td>
                            <td><?= $order['email_id']; ?></td>
                            <td><?= $order['address']; ?></td> <!-- ✅ Display Address -->

                            <td><?= $order['menu_item']; ?></td>
                            <td>₹<?= number_format($order['total'], 2); ?></td>
                            <td><?= $order['payment_mode']; ?></td>
                            <td>
                                <span class="badge bg-<?= ($order['order_status'] == 'Successful') ? 'success' : 'warning'; ?>">
                                    <?= $order['order_status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="delete_orders.php?order_id=<?= $order['order_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
                </div>
<!-- JavaScript for Sidebar Navigation -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#sidebar a").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            document.querySelectorAll(".content").forEach(section => section.classList.remove("active"));
            const target = document.querySelector(link.getAttribute("href"));
            if (target) target.classList.add("active");
        });
    });
});
</script>

</body>
</html>  