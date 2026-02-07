<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/login.php");
    exit;
}
include 'includes/config.php';

if (isset($_POST['id']) && isset($_FILES['new_image'])) {
    $id = intval($_POST['id']);
    $fileName = time() . "_" . basename($_FILES['new_image']['name']);
    $target = "uploads/" . $fileName;
    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $target)) {
        // remove old file
        $res = $conn->query("SELECT image_path FROM apartment_images WHERE id=$id");
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            $oldFile = "uploads/" . $row['image_path'];
            if (file_exists($oldFile)) unlink($oldFile);
        }
        // update DB
        $conn->query("UPDATE apartment_images SET image_path='$fileName' WHERE id=$id");
    }
}
header("Location: admin-dashboard.php");
exit;
