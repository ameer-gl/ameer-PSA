<?php
include 'includes/config.php';

echo "Adding sample images to database...\n\n";

// Sample images data
$sampleImages = [
    // Aerial views
    ['category' => 'aerial', 'slot' => 1, 'image' => 'sample_aerial_1.jpg'],
    ['category' => 'aerial', 'slot' => 2, 'image' => 'sample_aerial_2.jpg'],
    ['category' => 'aerial', 'slot' => 3, 'image' => 'sample_aerial_3.jpg'],
    ['category' => 'aerial', 'slot' => 4, 'image' => 'sample_aerial_4.jpg'],
    
    // Eye level views
    ['category' => 'eyelevel', 'slot' => 1, 'image' => 'sample_eyelevel_1.jpg'],
    ['category' => 'eyelevel', 'slot' => 2, 'image' => 'sample_eyelevel_2.jpg'],
    ['category' => 'eyelevel', 'slot' => 3, 'image' => 'sample_eyelevel_3.jpg'],
    ['category' => 'eyelevel', 'slot' => 4, 'image' => 'sample_eyelevel_4.jpg'],
    
    // Blueprints
    ['category' => 'blueprint', 'slot' => 1, 'image' => 'sample_blueprint_1.jpg'],
    ['category' => 'blueprint', 'slot' => 2, 'image' => 'sample_blueprint_2.jpg'],
    ['category' => 'blueprint', 'slot' => 3, 'image' => 'sample_blueprint_3.jpg'],
    ['category' => 'blueprint', 'slot' => 4, 'image' => 'sample_blueprint_4.jpg'],
];

$stmt = $conn->prepare("INSERT INTO apartment_images (category, slot_number, image_path) VALUES (?, ?, ?)");

foreach ($sampleImages as $img) {
    $stmt->bind_param("sis", $img['category'], $img['slot'], $img['image']);
    if ($stmt->execute()) {
        echo "✓ Added: {$img['category']} #{$img['slot']}\n";
    } else {
        echo "✗ Error: {$img['category']} #{$img['slot']} - " . $stmt->error . "\n";
    }
}

$stmt->close();

echo "\n═══════════════════════════════════════\n";
echo "Sample images added to database!\n";
echo "═══════════════════════════════════════\n";
echo "\nNow creating placeholder image files...\n";

// Create placeholder images
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
    echo "✓ Created uploads directory\n";
}

// Create a simple placeholder image using GD
function createPlaceholder($filename, $text, $color) {
    $width = 800;
    $height = 600;
    
    $image = imagecreatetruecolor($width, $height);
    
    // Colors
    list($r, $g, $b) = $color;
    $bgColor = imagecolorallocate($image, $r, $g, $b);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $borderColor = imagecolorallocate($image, 0, 255, 140);
    
    // Fill background
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);
    
    // Draw border
    imagerectangle($image, 10, 10, $width-10, $height-10, $borderColor);
    imagerectangle($image, 11, 11, $width-11, $height-11, $borderColor);
    
    // Add text
    $font = 5; // Built-in font
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    imagestring($image, $font, $x, $y, $text, $textColor);
    
    // Save image
    imagejpeg($image, 'uploads/' . $filename, 90);
    imagedestroy($image);
}

// Create placeholder images for each category
$colors = [
    'aerial' => [26, 147, 111],      // Green
    'eyelevel' => [15, 77, 37],      // Dark green
    'blueprint' => [10, 46, 21],     // Darker green
];

foreach ($sampleImages as $img) {
    $text = strtoupper($img['category']) . " VIEW #" . $img['slot'];
    createPlaceholder($img['image'], $text, $colors[$img['category']]);
    echo "✓ Created: uploads/{$img['image']}\n";
}

echo "\n═══════════════════════════════════════\n";
echo "✅ ALL DONE!\n";
echo "═══════════════════════════════════════\n";
echo "\nYou can now:\n";
echo "1. Login as user (john@example.com / password123)\n";
echo "2. View dashboard\n";
echo "3. Scroll down to see the gallery\n";
echo "4. See 12 sample images in 3 categories\n";
echo "\nOr login as admin to upload real images!\n";

$conn->close();
?>
