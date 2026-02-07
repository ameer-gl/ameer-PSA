<?php
include 'includes/config.php';

echo "Checking database for images...\n\n";

$result = $conn->query("SELECT * FROM apartment_images ORDER BY category, slot_number");

if ($result->num_rows > 0) {
    echo "Found " . $result->num_rows . " images:\n";
    echo "═══════════════════════════════════════\n";
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} | Category: {$row['category']} | Slot: {$row['slot_number']} | Path: {$row['image_path']}\n";
    }
} else {
    echo "❌ No images found in database!\n";
    echo "\nLet's add some sample images...\n";
}

$conn->close();
?>
