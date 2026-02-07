<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/login.php");
    exit;
}
include 'includes/config.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $res = $conn->query("SELECT image_path FROM apartment_images WHERE id=$id");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $file = "uploads/" . $row['image_path'];
        if (file_exists($file)) unlink($file);
    }
    $conn->query("DELETE FROM apartment_images WHERE id=$id");
}
header("Location: admin-dashboard.php");
exit;
