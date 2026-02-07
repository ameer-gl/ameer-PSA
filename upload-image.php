<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $category   = $_POST['category'];
    $slotNumber = $_POST['slot_number'];
    $fileName   = time() . "_" . basename($_FILES['image']['name']);
    $targetDir  = "uploads/";
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // Insert or update row
        $stmt = $conn->prepare("
            INSERT INTO apartment_images (category, slot_number, image_path) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE image_path = VALUES(image_path)
        ");
        $stmt->bind_param("sis", $category, $slotNumber, $fileName);
        $stmt->execute();
        $stmt->close();

        header("Location: admin-dashboard.php?success=1");
        exit;
    } else {
        echo "Error uploading image.";
    }
}
?>
