<?php
session_start();
include 'includes/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageId = isset($_POST['image_id']) ? intval($_POST['image_id']) : 0;
    $userId = $_SESSION['user_id'];
    
    if ($imageId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid image']);
        exit;
    }
    
    // Check if already in wishlist
    $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND image_id = ?");
    $check->bind_param("ii", $userId, $imageId);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        // Remove from wishlist
        $delete = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND image_id = ?");
        $delete->bind_param("ii", $userId, $imageId);
        
        if ($delete->execute()) {
            echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Removed from wishlist']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error removing from wishlist']);
        }
        $delete->close();
    } else {
        // Add to wishlist
        $insert = $conn->prepare("INSERT INTO wishlist (user_id, image_id) VALUES (?, ?)");
        $insert->bind_param("ii", $userId, $imageId);
        
        if ($insert->execute()) {
            echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Added to wishlist']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding to wishlist']);
        }
        $insert->close();
    }
    
    $check->close();
}

$conn->close();
?>
