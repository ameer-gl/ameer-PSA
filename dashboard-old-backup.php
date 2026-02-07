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

$pageTitle = "Your Dashboard - Allami Homes";
include 'includes/header.php';
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


        
        ?>
    </div>
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-green: #0a2e15;
            --medium-green: #0f4d25;
            --light-green: #1a936f;
            --accent-green: #3cf281;
            --black: #121212;
            --dark-gray: #1e1e1e;
            --white: #ffffff;
            --light-gray: #f1f1f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--black);
            color: var(--white);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Dashboard Header */
        .dashboard-header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeIn 1s ease;
        }

        .dashboard-header h1 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--accent-green), var(--light-green));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .dashboard-header p {
            font-size: 1.2rem;
            color: var(--light-gray);
        }

        /* Hero Image */
        .hero-image {
            margin-bottom: 4rem;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: slideUp 1s ease;
        
        }

        .hero-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, var(--black));
            z-index: 1;
        }

        .hero-image img {
            width: 200%;
            display: block;
            transition: transform 0.5s ease;
        }

        .hero-image:hover img {
            transform: scale(1.03);
        }

        /* Gallery Sections */
        .image-gallery {
            margin-bottom: 4rem;
        }

        .image-gallery h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--accent-green);
            position: relative;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .image-gallery h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(to right, var(--accent-green), transparent);
        }

        .gallery-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 3rem;
            justify-content: flex-start;
        }

        .gallery-item {
            flex: 0 0 calc(25% - 1.5rem); /* 4 items per row with gap accounted for */
            background: linear-gradient(145deg, var(--dark-green), var(--dark-gray));
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border: 1px solid rgba(60, 242, 129, 0.1);
            cursor: pointer;
            animation: fadeIn 0.8s ease;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border-color: var(--accent-green);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item p {
            padding: 1rem;
            text-align: center;
            font-weight: 500;
            color: var(--light-gray);
        }

        /* Feedback Section */
        .feedback {
            background: linear-gradient(145deg, var(--dark-gray), var(--dark-green));
            padding: 3rem;
            border-radius: 15px;
            margin-top: 4rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .feedback h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: var(--accent-green);
        }

        .feedback textarea {
            width: 100%;
            padding: 1rem;
            background-color: var(--dark-gray);
            border: 1px solid var(--medium-green);
            border-radius: 8px;
            color: var(--white);
            font-size: 1rem;
            margin-bottom: 1rem;
            min-height: 150px;
            resize: vertical;
        }

        .feedback textarea:focus {
            outline: none;
            border-color: var(--accent-green);
        }

        .feedback button {
            background: linear-gradient(to right, var(--light-green), var(--accent-green));
            color: var(--black);
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .feedback button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(60, 242, 129, 0.3);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            overflow: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
        }

        .modal-content {
            max-width: 90%;
            max-height: 80%;
            object-fit: contain;
            border-radius: 8px;
            animation: zoomIn 0.3s ease;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: var(--white);
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: var(--accent-green);
        }
        

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--medium-green);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            z-index: 1001;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Responsive Design - Rows Layout */
        @media screen and (max-width: 1200px) {
            .dashboard-container {
                padding: 1.5rem;
            }
            
            .gallery-item {
                flex: 0 0 calc(33.333% - 1.5rem); /* 3 items per row */
            }
        }

        @media screen and (max-width: 992px) {
            .dashboard-header h1 {
                font-size: 2.3rem;
            }
            
            .gallery-item {
                flex: 0 0 calc(50% - 1.5rem); /* 2 items per row */
            }
        }

        @media screen and (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .dashboard-header p {
                font-size: 1.1rem;
            }
            
            .image-gallery h2 {
                font-size: 1.7rem;
            }
            
            .gallery-section {
                gap: 1rem;
            }
            
            .feedback {
                padding: 2rem;
            }
            
            .feedback h2 {
                font-size: 1.7rem;
            }

            .mobile-menu-btn {
                display: block;
            }
        }

        @media screen and (max-width: 576px) {
            .dashboard-container {
                padding: 1rem;
            }
            
            .dashboard-header h1 {
                font-size: 1.8rem;
            }
            
            .gallery-item {
                flex: 0 0 100%; /* 1 item per row */
            }
            
            .gallery-item img {
                height: 180px;
            }
            
            .feedback {
                padding: 1.5rem;
            }
            
            .feedback h2 {
                font-size: 1.5rem;
            }
            
            .close-modal {
                top: 10px;
                right: 15px;
                font-size: 30px;
            }

            .hero-image {
                margin-bottom: 2rem;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--medium-green);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--light-green);
        }
    </style>
</head>
 <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">Experience <span>Luxury</span> Living Spaces</h1>
                <p class="hero-subtitle">Discover premium apartments designed for modern living with sustainability and innovation at their core.</p>
              
            </div>
            <div class="hero-image">
                <img src="image.jpg" alt="Luxury">
            </div>
        </div>
    </section>

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

<body>
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars"></i>
    </button>

   
       

        <!-- Gallery Sections -->
        <section class="image-gallery">
            <?php foreach ($images as $category => $list): ?>
                <h2><?php echo $category; ?></h2>
                <div class="gallery-section">
                    <?php if (!empty($list)): ?>
                        <?php foreach ($list as $img): ?>
                            <div class="gallery-item">
                                <img src="<?php echo $img['src']; ?>" alt="<?php echo $category . ' ' . $img['slot']; ?>">
                                <p><?php echo $category . " #" . $img['slot']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No images uploaded yet.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <!-- Feedback form -->
        <section class="feedback">
            <h2>Send Feedback</h2>
            <form method="POST" action="submit-feedback.php">
                <textarea name="message" placeholder="Write your feedback..." required></textarea><br>
                <button type="submit">Send Feedback</button>
            </form>
        </section>
    </div>

    <!-- Modal -->
    <div class="modal" id="image-modal">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modal-image">
    </div>

   

    <script>
        // JS modal code
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                const imgSrc = this.querySelector('img').src;
                const modal = document.getElementById('image-modal');
                const modalImg = document.getElementById('modal-image');
                
                modal.classList.add('active');
                modalImg.src = imgSrc;
                document.body.style.overflow = 'hidden';
            });
        });

        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('image-modal').classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        document.getElementById('image-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('image-modal').classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Add animation to gallery items as they appear
        document.addEventListener('DOMContentLoaded', function() {
            const galleryItems = document.querySelectorAll('.gallery-item');
            galleryItems.forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Mobile menu functionality
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            // This would toggle a mobile menu - you can implement based on your needs
            alert('Mobile menu would open here. Implement navigation links as needed.');
        });
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>