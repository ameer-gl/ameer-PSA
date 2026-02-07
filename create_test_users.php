<?php
// Create test users
include 'includes/config.php';

$testUsers = [
    [
        'username' => 'john_doe',
        'email' => 'john@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'role' => 'user'
    ],
    [
        'username' => 'jane_smith',
        'email' => 'jane@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'role' => 'user'
    ],
    [
        'username' => 'mike_wilson',
        'email' => 'mike@example.com',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'role' => 'user'
    ]
];

echo "Creating test users...\n\n";

foreach ($testUsers as $user) {
    // Check if user already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $user['email']);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        echo "✓ User {$user['username']} already exists\n";
    } else {
        // Create user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user['username'], $user['email'], $user['password'], $user['role']);
        
        if ($stmt->execute()) {
            echo "✓ Created user: {$user['username']} ({$user['email']})\n";
        } else {
            echo "✗ Error creating {$user['username']}: " . $conn->error . "\n";
        }
        $stmt->close();
    }
    $check->close();
}

echo "\n===========================================\n";
echo "TEST USERS CREATED\n";
echo "===========================================\n";
echo "All test users have password: password123\n";
echo "\nUsers:\n";
echo "1. john@example.com (john_doe)\n";
echo "2. jane@example.com (jane_smith)\n";
echo "3. mike@example.com (mike_wilson)\n";
echo "===========================================\n";
echo "\nYou can now view these users in the admin dashboard!\n";
echo "Visit: http://localhost:8000/admin-dashboard.php\n";

$conn->close();
?>
