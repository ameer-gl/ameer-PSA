<?php
echo "Creating placeholder images...\n\n";

if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
    echo "✓ Created uploads directory\n";
}

// Copy the existing image.jpg as placeholders
$sourceImage = 'image.jpg';

if (file_exists($sourceImage)) {
    $images = [
        'sample_aerial_1.jpg', 'sample_aerial_2.jpg', 'sample_aerial_3.jpg', 'sample_aerial_4.jpg',
        'sample_eyelevel_1.jpg', 'sample_eyelevel_2.jpg', 'sample_eyelevel_3.jpg', 'sample_eyelevel_4.jpg',
        'sample_blueprint_1.jpg', 'sample_blueprint_2.jpg', 'sample_blueprint_3.jpg', 'sample_blueprint_4.jpg',
    ];
    
    foreach ($images as $img) {
        copy($sourceImage, 'uploads/' . $img);
        echo "✓ Created: uploads/$img\n";
    }
    
    echo "\n═══════════════════════════════════════\n";
    echo "✅ ALL DONE!\n";
    echo "═══════════════════════════════════════\n";
    echo "\n12 sample images created in uploads folder!\n";
    echo "\nNow you can:\n";
    echo "1. Visit: http://localhost:8000\n";
    echo "2. Login as user:\n";
    echo "   - Email: john@example.com\n";
    echo "   - Password: password123\n";
    echo "3. Scroll down to see the gallery\n";
    echo "4. You'll see 12 images in 3 categories!\n";
    echo "\n🎉 Images are now visible on user dashboard!\n";
} else {
    echo "❌ Source image not found. Please ensure image.jpg exists.\n";
}
?>
