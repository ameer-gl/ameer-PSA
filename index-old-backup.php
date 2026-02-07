<?php
session_start();

// If already logged in → go to dashboards
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin-dashboard.php");
    } else {
        header("Location: dashboard.php");
    }
    exit;
} else {
    // Not logged in → show login page
    header("Location: auth/login.php");
    exit;
}
