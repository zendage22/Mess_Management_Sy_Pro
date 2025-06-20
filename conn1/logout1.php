<?php
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset(); // Unset session variables
    session_destroy(); // Destroy session
    setcookie(session_name(), '', time() - 3600, '/'); // Remove session cookie
}

// Start output buffering to prevent "headers already sent" error
ob_start();
header("Location: admin_login.php");
ob_end_flush();
exit();
?>
