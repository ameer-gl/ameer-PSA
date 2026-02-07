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
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$recentFeedback = $conn->query("SELECT COUNT(*) as count FROM feedback WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['count'];

// Get current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 'overview';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Allami Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin-sidebar.css">
    <link rel="stylesheet" href="css/admin-dashboard.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-building"></i>
                </div>
                <div class="sidebar-title">ALLAMI HOMES</div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="?page=overview" class="nav-item <?php echo $currentPage == 'overview' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-chart-line"></i></span>
                        <span class="nav-text">Overview</span>
                    </a>
                    <a href="?page=images" class="nav-item <?php echo $currentPage == 'images' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-images"></i></span>
                        <span class="nav-text">Images</span>
                        <span class="nav-badge"><?php echo $totalImages; ?></span>
                    </a>
                    <a href="?page=users" class="nav-item <?php echo $currentPage == 'users' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-users"></i></span>
                        <span class="nav-text">Users</span>
                        <span class="nav-badge"><?php echo $totalUsers; ?></span>
                    </a>
                    <a href="?page=feedback" class="nav-item <?php echo $currentPage == 'feedback' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-comments"></i></span>
                        <span class="nav-text">Feedback</span>
                        <span class="nav-badge"><?php echo $totalFeedback; ?></span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <a href="?page=upload" class="nav-item <?php echo $currentPage == 'upload' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-cloud-upload-alt"></i></span>
                        <span class="nav-text">Upload Images</span>
                    </a>
                    <a href="?page=settings" class="nav-item <?php echo $currentPage == 'settings' ? 'active' : ''; ?>">
                        <span class="nav-icon"><i class="fas fa-cog"></i></span>
                        <span class="nav-text">Settings</span>
                    </a>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-profile">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </div>
                    <div class="user-info">
                        <div class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
                <form action="auth/logout.php" method="POST">
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <h1 class="page-title">
                    <?php
                    $titles = [
                        'overview' => 'Dashboard Overview',
                        'images' => 'Image Management',
                        'users' => 'User Management',
                        'feedback' => 'Feedback Management',
                        'upload' => 'Upload Images',
                        'settings' => 'Settings'
                    ];
                    echo $titles[$currentPage] ?? 'Dashboard';
                    ?>
                </h1>
                <div class="top-bar-actions">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search...">
                    </div>
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <?php if($recentFeedback > 0): ?>
                            <span class="notification-badge"><?php echo $recentFeedback; ?></span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <?php
                // Include different content based on page
                switch($currentPage) {
                    case 'overview':
                        include 'admin-pages/overview.php';
                        break;
                    case 'images':
                        include 'admin-pages/images.php';
                        break;
                    case 'users':
                        include 'admin-pages/users.php';
                        break;
                    case 'feedback':
                        include 'admin-pages/feedback.php';
                        break;
                    case 'upload':
                        include 'admin-pages/upload.php';
                        break;
                    case 'settings':
                        include 'admin-pages/settings.php';
                        break;
                    default:
                        include 'admin-pages/overview.php';
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
        <i class="fas fa-bars"></i>
    </button>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            
            const icon = document.querySelector('.sidebar-toggle i');
            if (sidebar.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-chevron-left';
            }
        }

        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !mobileBtn.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
