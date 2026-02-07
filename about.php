<?php
$pageTitle = "About Us - Allami Homes";
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Allami Homes</title>
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

        .about-container {
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

        .about-container::before {
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

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .team-member {
            background: rgba(15, 77, 37, 0.4);
            border: 1px solid rgba(26, 147, 111, 0.4);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .team-member::before {
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

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-color: var(--neon-green);
        }

        .team-member:hover::before {
            transform: scaleX(1);
        }

        .team-member h3 {
            color: var(--white);
            margin-bottom: 0.5rem;
            font-size: 1.4rem;
        }

        .team-member p {
            color: var(--neon-green);
            font-weight: 500;
            margin-bottom: 0;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: rgba(217, 221, 218, 0.4);
            border: 1px solid rgba(26, 147, 111, 0.4);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            border-color: var(--neon-green);
            transform: translateX(5px);
        }

        .contact-icon {
            margin-right: 1rem;
            font-size: 1.5rem;
            color: var(--neon-green);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 255, 140, 0.1);
            border-radius: 50%;
        }

        .contact-text {
            color: var(--gray);
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
            .about-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .team-grid {
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
            
            .contact-info {
                grid-template-columns: 1fr;
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
    
    <div class="about-container">
        <h1>About Allami Homes</h1>
        <p>Allami Homes is dedicated to providing luxury apartment living with exceptional amenities and stunning views. We combine innovative design with sustainable practices to create spaces that are both beautiful and functional.</p>
        
        <h2>Our Mission</h2>
        <p>To create beautiful living spaces that feel like home from the moment you step inside. We believe that everyone deserves a home that inspires, comforts, and reflects their unique lifestyle.</p>
        
        <h2>Our Vision</h2>
        <p>To redefine modern living by creating sustainable, community-focused developments that enhance the lives of our residents and contribute positively to the environment.</p>
        
        <h2>Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <h3>John Smith</h3>
                <p>Founder & CEO</p>
            </div>
            <div class="team-member">
                <h3>Sarah Johnson</h3>
                <p>Lead Architect</p>
            </div>
            <div class="team-member">
                <h3>Michael Brown</h3>
                <p>Interior Designer</p>
            </div>
        </div>
        
        <h2>Contact Us</h2>
        <div class="contact-info">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-text">info@allamihomes.com</div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-text">+2348035935891</div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-text">plot 94 ,katampe,abuja areacouncil.abuja</div>
            </div>
        </div>
    </div>

    <script>
        // Add animations when scrolling
        document.addEventListener('DOMContentLoaded', function() {
            const teamMembers = document.querySelectorAll('.team-member');
            const contactItems = document.querySelectorAll('.contact-item');
            
            // Animate team members on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });
            
            // Set initial state for animation
            teamMembers.forEach(member => {
                member.style.opacity = 0;
                member.style.transform = 'translateY(20px)';
                member.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(member);
            });
            
            contactItems.forEach(item => {
                item.style.opacity = 0;
                item.style.transform = 'translateX(-20px)';
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(item);
            });
        });
    </script>
</body>
</html>

<?php include 'includes/footer.php'; ?>