

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Prevent users from accessing the system without login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
