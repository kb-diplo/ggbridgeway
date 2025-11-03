<?php
require_once '../includes/config.php';

// Redirect to dashboard if logged in, otherwise to login
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
?>
