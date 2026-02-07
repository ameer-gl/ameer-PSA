<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

// Role check for admin page
if (basename($_SERVER['PHP_SELF']) == "admin-dashboard.php" && $_SESSION['role'] != 'admin') {
    header("Location: dashboard.php");
    exit;
}

include 'includes/config.php';

// Fetch images from database
$sql = "SELECT category, slot_number, image_path 
        FROM apartment_images 
        ORDER BY category, slot_number ASC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}

$images = [];

while ($row = $result->fetch_assoc()) {
    $cat = $row['category'];
    $images[$cat][] = [
        "slot" => $row['slot_number'],
        "src"  => (!empty($row['image_path']) && file_exists("uploads/" . $row['image_path']))
                    ? "uploads/" . $row['image_path']
                    : "images/placeholder.jpg"
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Allami Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/user-dashboard.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="user-nav">
        <div class="nav-brand">
            <div class="nav-icon"><i class="fas fa-home"></i></div>
            <div class="nav-title">ALLAMI HOMES</div>
        </div>
        <div class="nav-user">
            <div class="user-welcome">
                Welcome, <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </div>
            <a href="auth/logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Experience <span>Luxury</span> Living Spaces</h1>
                    <p class="hero-subtitle">Discover premium apartments designed for modern living with sustainability and innovation at their core. Your dream home awaits.</p>
                </div>
                <div class="hero-image">
                    <img src="image.jpg" alt="Luxury Apartment" onerror="this.src='https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=800'">
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2 class="section-title">Why Choose Us</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="feature-title">Eco-Friendly Design</h3>
                    <p class="feature-desc">Our buildings incorporate sustainable materials and energy-efficient systems for a greener future.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Advanced Security</h3>
                    <p class="feature-desc">Smart security systems with biometric access and 24/7 monitoring for your peace of mind.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="feature-title">Smart Home Tech</h3>
                    <p class="feature-desc">Control lighting, temperature, and security with AI-powered home automation systems.</p>
                </div>
            </div>
        </section>

        <!-- Gallery Sections -->
        <section class="image-gallery">
            <?php 
            $categoryIcons = [
                'aerial' => '🛩️',
                'eyelevel' => '👁️',
                'blueprint' => '📐'
            ];
            
            foreach ($images as $category => $list): 
                $icon = $categoryIcons[$category] ?? '📷';
            ?>
                <h2><?php echo $icon . ' ' . ucfirst($category); ?></h2>
                <div class="gallery-section">
                    <?php if (!empty($list)): ?>
                        <?php foreach ($list as $img): ?>
                            <div class="gallery-item" onclick="openModal('<?php echo $img['src']; ?>')">
                                <img src="<?php echo $img['src']; ?>" alt="<?php echo $category . ' ' . $img['slot']; ?>" loading="lazy">
                                <p><?php echo ucfirst($category) . " #" . $img['slot']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: var(--light-gray); text-align: center; padding: 3rem; grid-column: 1/-1;">
                            <i class="fas fa-image" style="font-size: 4rem; display: block; margin-bottom: 1rem; opacity: 0.3;"></i>
                            No images uploaded yet for this category.
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Feedback form -->
        <section class="feedback">
            <h2>
                <i class="fas fa-comment-dots"></i>
                Send Us Your Feedback
            </h2>
            <form method="POST" action="submit-feedback.php">
                <textarea name="message" placeholder="Share your thoughts, suggestions, or questions with us..." required></textarea>
                <button type="submit">
                    <i class="fas fa-paper-plane"></i> Send Feedback
                </button>
            </form>
            <?php if(isset($_GET['feedback']) && $_GET['feedback'] == 'success'): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle"></i> Thank you! Your feedback has been submitted successfully.
                </div>
            <?php endif; ?>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal" id="image-modal" onclick="closeModal()">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>

    <script>
        function openModal(src) {
            const modal = document.getElementById('image-modal');
            const modalImg = document.getElementById('modal-image');
            modal.classList.add('active');
            modalImg.src = src;
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('image-modal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
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

        // Lazy loading animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.gallery-item, .feature-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        // Auto-hide success message
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
