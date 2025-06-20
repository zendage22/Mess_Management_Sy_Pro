<?php



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_now'])) {
    $plan_id = $_POST['plan_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];

    // Insert payment into the database
    $stmt = $conn->prepare("INSERT INTO payments (user_id, amount, payment_status, payment_method, payment_date) VALUES (?, ?, 'Success', ?, NOW())");
    $stmt->bind_param("ids", $user_id, $amount, $payment_method);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Payment Successful!'); window.location.href='user_dash.php';</script>";
    } else {
        echo "<script>alert('❌ Payment Failed!');</script>";
    }
    $stmt->close();
}

?>
