<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/login.php");
    exit;
}

include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Feedback deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting feedback.";
    }

    $stmt->close();
}

header("Location: admin-dashboard.php");
exit;
?>
