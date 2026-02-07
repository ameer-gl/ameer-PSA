<?php
session_start();
include 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $message = trim($_POST['message']);

    $stmt = $conn->prepare("INSERT INTO feedback (user_id, message) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $message);

    if ($stmt->execute()) {
        header("Location: dashboard.php?feedback=sent");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
