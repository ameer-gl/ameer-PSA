<?php
include 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Allami Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --dark-green: #0a2e15;
            --medium-green: #0f4d25;
            --light-green: #1a936f;
            --neon-green: #00ff8c;
            --black: #121212;
            --white: #ffffff;
            --gray: #e0e0e0;
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
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--dark-green) 0%, transparent 100%);
            z-index: -1;
        }

        .grid-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(18, 18, 18, 0.9) 1px, transparent 1px),
                linear-gradient(90deg, rgba(18, 18, 18, 0.9) 1px, transparent 1px);
            background-size: 20px 20px;
            z-index: -2;
            perspective: 500px;
            transform-style: preserve-3d;
            animation: gridMove 20s infinite linear;
        }

        @keyframes gridMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 20px 20px;
            }
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 15s infinite linear;
        }

        .shape:nth-child(1) {
            width: 300px;
            height: 300px;
            background: var(--neon-green);
            top: -150px;
            left: -150px;
            animation-delay: 0s;
            animation-duration: 25s;
        }

        .shape:nth-child(2) {
            width: 200px;
            height: 200px;
            background: var(--light-green);
            bottom: -100px;
            right: 20%;
            animation-delay: -5s;
            animation-duration: 20s;
        }

        .shape:nth-child(3) {
            width: 150px;
            height: 150px;
            background: var(--medium-green);
            top: 30%;
            right: -75px;
            animation-delay: -10s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
            100% {
                transform: translateY(0) rotate(360deg);
            }
        }

        .services-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(10, 46, 21, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(26, 147, 111, 0.3);
            border-radius: 16px;
            box-shadow: 0 0 30px rgba(0, 255, 140, 0.2);
            transform-style: preserve-3d;
            animation: containerAppear 1s forwards;
            overflow: hidden;
            position: relative;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .services-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(26, 147, 111, 0.1),
                rgba(26, 147, 111, 0.05),
                transparent
            );
            transform: rotate(30deg);
            z-index: -1;
        }

        @keyframes containerAppear {
            0% {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        h1 {
            text-align: center;
            margin-bottom: 2rem;
            font-weight: 600;
            font-size: 2.5rem;
            color: var(--white);
            text-shadow: 0 0 10px rgba(0, 255, 140, 0.5);
            position: relative;
            padding-bottom: 15px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--neon-green), transparent);
            animation: linePulse 2s infinite;
        }

        h2 {
            margin: 2rem 0 1rem;
            font-weight: 600;
            font-size: 1.8rem;
            color: var(--neon-green);
            position: relative;
            padding-left: 15px;
        }

        h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 25px;
            background: var(--neon-green);
            border-radius: 2px;
        }

        p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 1.1rem;
            color: var(--white);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .service-card {
            background: rgba(15, 77, 37, 0.4);
            border: 1px solid rgba(26, 147, 111, 0.4);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--neon-green), var(--light-green));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border-color: var(--neon-green);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 255, 140, 0.1);
            border-radius: 50%;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            color: var(--neon-green);
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
            background: rgba(0, 255, 140, 0.2);
            box-shadow: 0 0 20px rgba(0, 255, 140, 0.3);
        }

        .service-card h3 {
            color: var(--white);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .service-card p {
            color: var(--white);
            margin-bottom: 1.5rem;
        }

        .service-features {
            list-style: none;
            margin-top: auto;
            text-align: left;
            width: 100%;
        }

        .service-features li {
            padding: 0.5rem 0;
            color: var(--white);
            position: relative;
            padding-left: 1.5rem;
        }

        .service-features li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--neon-green);
            font-weight: bold;
        }

        .cta-section {
            text-align: center;
            margin: 3rem 0;
            padding: 2rem;
            background: rgba(15, 77, 37, 0.4);
            border: 1px solid rgba(26, 147, 111, 0.4);
            border-radius: 12px;
        }

        .cta-button {
            display: inline-block;
            padding: 1rem 2rem;
            background: linear-gradient(135deg, var(--medium-green), var(--light-green));
            border: none;
            border-radius: 8px;
            color: var(--white);
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            text-decoration: none;
            margin-top: 1rem;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        @keyframes linePulse {
            0%, 100% {
                opacity: 0.7;
                width: 100px;
            }
            50% {
                opacity: 1;
                width: 150px;
            }
        }

        @media (max-width: 768px) {
            .services-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .services-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }
            
            h2 {
                font-size: 1.3rem;
            }
            
            p {
                font-size: 1rem;
            }
            
            .service-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="grid-background"></div>
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="services-container">
        <h1>Our Premium Services</h1>
        <p>At Allami Homes, we offer a comprehensive range of luxury real estate services designed to meet your every need. From finding your dream home to property management, our expert team is here to guide you every step of the way.</p>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3>Luxury Home Sales</h3>
                <p>Discover exclusive luxury properties with stunning features and premium amenities.</p>
                <ul class="service-features">
                    <li>Exclusive property listings</li>
                    <li>Virtual tours</li>
                    <li>Professional photography</li>
                    <li>Expert negotiation</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3>Property Management</h3>
                <p>Comprehensive management services to maintain and enhance your property's value.</p>
                <ul class="service-features">
                    <li>24/7 maintenance</li>
                    <li>Tenant screening</li>
                    <li>Rent collection</li>
                    <li>Regular inspections</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-paint-roller"></i>
                </div>
                <h3>Interior Design</h3>
                <p>Transform your space with our expert interior design services tailored to your taste.</p>
                <ul class="service-features">
                    <li>Custom design concepts</li>
                    <li>Furniture selection</li>
                    <li>Color consultation</li>
                    <li>Project management</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h3>Move-In Ready Homes</h3>
                <p>Fully furnished and equipped properties for immediate occupancy.</p>
                <ul class="service-features">
                    <li>Fully furnished options</li>
                    <li>Smart home technology</li>
                    <li>Premium appliances</li>
                    <li>Utilities setup</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Property Insurance</h3>
                <p>Comprehensive insurance solutions to protect your valuable investment.</p>
                <ul class="service-features">
                    <li>Customized coverage</li>
                    <li>Competitive rates</li>
                    <li>Quick claims processing</li>
                    <li>24/7 support</li>
                </ul>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Consultation Services</h3>
                <p>Expert advice on real estate investments, market trends, and property valuation.</p>
                <ul class="service-features">
                    <li>Market analysis</li>
                    <li>Investment strategies</li>
                    <li>Property valuation</li>
                    <li>Portfolio management</li>
                </ul>
            </div>
        </div>
        
       
    </div>

    <script>
        // Add animations when scrolling
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            
            // Animate service cards on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            // Set initial state for animation
            serviceCards.forEach(card => {
                card.style.opacity = 0;
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(card);
            });
        });
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>