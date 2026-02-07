<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: auth/login.php");
    exit;
}

include 'includes/config.php';

// Get statistics
$totalImages = $conn->query("SELECT COUNT(*) as count FROM apartment_images")->fetch_assoc()['count'];
$totalFeedback = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='user'")->fetch_assoc()['count'];
$recentFeedback = $conn->query("SELECT COUNT(*) as count FROM feedback WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Allami Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-dashboard.css">
</head>
<body>
    <header class="admin-header">
        <div class="admin-logo">
            <div class="admin-logo-icon"><i class="fas fa-building"></i></div>
            <div class="admin-logo-text">ALLAMI HOMES</div>
        </div>
        <a href="auth/logout.php" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </header>

    <div class="admin-dashboard">
        <h1 class="dashboard-title">Admin Dashboard</h1>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-images"></i></div>
                <div class="stat-value"><?php echo $totalImages; ?></div>
                <div class="stat-label">Total Images</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-comments"></i></div>
                <div class="stat-value"><?php echo $totalFeedback; ?></div>
                <div class="stat-label">Total Feedback</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-value"><?php echo $totalUsers; ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-value"><?php echo $recentFeedback; ?></div>
                <div class="stat-label">Recent Feedback</div>
            </div>
        </div>

        <!-- Upload Images Section -->
        <section class="dashboard-section">
            <h2 class="section-title">
                <i class="fas fa-cloud-upload-alt"></i>
                Upload Apartment Images
            </h2>
            
            <?php if(isset($_GET['success'])): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Operation completed successfully!
                </div>
            <?php endif; ?>
            
            <form action="upload-image.php" method="POST" enctype="multipart/form-data" class="admin-form">
                <div class="form-group">
                    <label for="category" class="form-label">
                        <i class="fas fa-tag"></i> Category
                    </label>
                    <select name="category" class="form-select" required>
                        <option value="aerial">🛩️ Aerial View</option>
                        <option value="eyelevel">👁️ Eye Level</option>
                        <option value="blueprint">📐 Blueprint</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="slot_number" class="form-label">
                        <i class="fas fa-hashtag"></i> Slot Number
                    </label>
                    <input type="number" name="slot_number" class="form-input" min="1" max="19" placeholder="1-19" required>
                </div>
                
                <div class="form-group">
                    <label for="image" class="form-label">
                        <i class="fas fa-image"></i> Select Image
                    </label>
                    <input type="file" name="image" class="form-input" accept="image/*" required>
                </div>
                
                <button type="submit" class="form-button">
                    <i class="fas fa-upload"></i> Upload Image
                </button>
            </form>
        </section>

        <!-- Current Images -->
        <section class="dashboard-section">
            <h2 class="section-title">
                <i class="fas fa-photo-video"></i>
                Current Apartment Images
            </h2>
            <div class="images-grid">
                <?php
                $images = $conn->query("SELECT * FROM apartment_images ORDER BY id DESC");
                if ($images->num_rows > 0) {
                    while ($img = $images->fetch_assoc()) {
                        $categoryIcons = [
                            'aerial' => '🛩️',
                            'eyelevel' => '👁️',
                            'blueprint' => '📐'
                        ];
                        $icon = $categoryIcons[$img['category']] ?? '📷';
                        echo "
                        <div class='image-card'>
                            <img src='uploads/{$img['image_path']}' alt='{$img['category']}' loading='lazy'>
                            <div class='image-info'>
                                <span class='image-category'>{$icon} {$img['category']}</span>
                                <p style='color: var(--light-gray); margin-top: 0.5rem;'>
                                    <i class='fas fa-hashtag'></i> Slot: {$img['slot_number']}
                                </p>
                                <div class='image-actions'>
                                    <form action='edit-image.php' method='POST' enctype='multipart/form-data' style='flex: 1;'>
                                        <input type='hidden' name='id' value='{$img['id']}'>
                                        <input type='file' name='new_image' accept='image/*' required style='display:none;' id='file-{$img['id']}' onchange='this.form.submit()'>
                                        <button type='button' class='btn-edit' onclick='document.getElementById(\"file-{$img['id']}\").click()'>
                                            <i class='fas fa-edit'></i> Edit
                                        </button>
                                    </form>
                                    <form action='delete-image.php' method='POST' onsubmit='return confirm(\"Delete this image?\")' style='flex: 1;'>
                                        <input type='hidden' name='id' value='{$img['id']}'>
                                        <button type='submit' class='btn-delete'>
                                            <i class='fas fa-trash'></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<p style='color: var(--light-gray); text-align: center; padding: 2rem;'>
                            <i class='fas fa-image' style='font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.3;'></i>
                            No images uploaded yet. Start by uploading your first image!
                          </p>";
                }
                ?>
            </div>
        </section>

        <!-- User Feedback -->
        <section class="dashboard-section">
            <h2 class="section-title">
                <i class="fas fa-comment-dots"></i>
                User Feedback
            </h2>
            <div class="feedback-container">
                <?php
                $result = $conn->query("
                    SELECT f.*, u.username 
                    FROM feedback f 
                    JOIN users u ON f.user_id = u.id 
                    ORDER BY f.created_at DESC
                ");
                
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='feedback-item'>
                                <div class='feedback-user'>
                                    <i class='fas fa-user-circle'></i>
                                    {$row['username']}
                                </div>
                                <div class='feedback-message'>{$row['message']}</div>
                                <div class='feedback-date'>
                                    <i class='fas fa-calendar-alt'></i>
                                    {$row['created_at']}
                                </div>
                                <form action='delete-feedback.php' method='POST' style='margin-top:15px;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' class='btn-delete' style='width: auto; padding: 0.6rem 1.5rem;' onclick='return confirm(\"Delete this feedback?\")'>
                                        <i class='fas fa-trash'></i> Delete
                                    </button>
                                </form>
                              </div>";
                    }
                } else {
                    echo "<div class='feedback-item' style='text-align: center; border-left: none;'>
                            <i class='fas fa-inbox' style='font-size: 3rem; display: block; margin-bottom: 1rem; opacity: 0.3; color: var(--accent-green);'></i>
                            <div class='feedback-message'>No feedback submitted yet.</div>
                          </div>";
                }
                ?>
            </div>
        </section>
    </div>

    <script>
        // Add smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Auto-hide success messages
        setTimeout(() => {
            const successMsg = document.querySelector('.success-message');
            if (successMsg) {
                successMsg.style.transition = 'opacity 0.5s';
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>
