<?php
include 'includes/config.php';

echo "Creating wishlist table...\n\n";

$sql = "CREATE TABLE IF NOT EXISTS wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (image_id) REFERENCES apartment_images(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, image_id),
    INDEX idx_user_id (user_id),
    INDEX idx_image_id (image_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if ($conn->query($sql)) {
    echo "✅ Wishlist table created successfully!\n";
} else {
    echo "Error: " . $conn->error . "\n";
}

$conn->close();
?>
