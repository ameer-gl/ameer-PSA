<?php
// Create admin user
include 'includes/config.php';

$username = 'admin';
$email = 'admin@allamihomes.com';
$password = password_hash('admin123', PASSWORD_BCRYPT);
$role = 'admin';

// Check if admin already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "✅ Admin user already exists!\n\n";
} else {
    // Create admin user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $role);
    
    if ($stmt->execute()) {
        echo "✅ Admin user created successfully!\n\n";
    } else {
        echo "❌ Error creating admin user: " . $conn->error . "\n\n";
    }
    $stmt->close();
}

echo "===========================================\n";
echo "ADMIN LOGIN CREDENTIALS\n";
echo "===========================================\n";
echo "Email:    admin@allamihomes.com\n";
echo "Password: admin123\n";
echo "===========================================\n";
echo "\nYou can now login at: http://localhost:8000\n";

$conn->close();
?>
