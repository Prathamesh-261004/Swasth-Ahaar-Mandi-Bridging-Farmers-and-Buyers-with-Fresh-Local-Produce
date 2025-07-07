<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌿 Swasth Ahaar Mand</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 50%, #81C784 100%);
            overflow: hidden;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
            font-size: 2rem;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
            font-size: 1.5rem;
        }

        .floating-element:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
            font-size: 1.8rem;
        }

        .floating-element:nth-child(4) {
            top: 40%;
            right: 30%;
            animation-delay: 1s;
            font-size: 1.2rem;
        }

        .floating-element:nth-child(5) {
            bottom: 15%;
            right: 10%;
            animation-delay: 3s;
            font-size: 1.6rem;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .hero-content {
            text-align: center;
            z-index: 2;
            position: relative;
            max-width: 800px;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .hero-title {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); }
            to { text-shadow: 2px 2px 20px rgba(255, 255, 255, 0.5); }
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(45deg, #FF6B6B, #FF8E8E);
            color: white;
            box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
        }

        .features-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-title {
            text-align: center;
            font-size: 2.5rem;
            color: #2E7D32;
            margin-bottom: 3rem;
            position: relative;
        }

        .features-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, #4CAF50, #81C784);
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #4CAF50, #81C784);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .feature-card h3 {
            color: #2E7D32;
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        .stats-section {
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
            color: white;
        }

        .stats-container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }

        .stat-item {
            padding: 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            background: linear-gradient(45deg, #FFD700, #FFA500);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .testimonial-section {
            padding: 5rem 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .testimonial-container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .testimonial-title {
            font-size: 2.5rem;
            margin-bottom: 3rem;
        }

        .testimonial-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.02);
        }

        .testimonial-text {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            font-style: italic;
        }

        .testimonial-author {
            font-weight: 600;
            color: #FFD700;
        }

        .footer {
            background: #1B5E20;
            color: white;
            padding: 3rem 2rem 1rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #4CAF50;
            margin-bottom: 1rem;
        }

        .footer-section p, .footer-section a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            line-height: 1.6;
        }

        .footer-section a:hover {
            color: #4CAF50;
        }

        .scroll-indicator {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            z-index: 100;
        }

        .scroll-indicator:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 300px;
            }
        }

        /* Particle animation */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 15s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Particle Background -->
    <div class="particles" id="particles"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-elements">
            <div class="floating-element">🌱</div>
            <div class="floating-element">🥕</div>
            <div class="floating-element">🍅</div>
            <div class="floating-element">🌽</div>
            <div class="floating-element">🥬</div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">🌿 Swasth Ahaar Mand-Khet Se Seedha, Swasth Ahaar Har Ghar.</h1>
            <p class="hero-subtitle">
                Connect directly with local farmers and fresh produce buyers. 
                Supporting sustainable agriculture and healthy communities, one harvest at a time.
            </p>
            
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">
                    🚀 Get Started
                </a>
                <a href="register.php" class="btn btn-secondary">
                    📝 Join Community
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <h2 class="features-title">Why Choose Our Platform?</h2>
            
            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">🌱</span>
                    <h3>Fresh & Local</h3>
                    <p>Connect with farmers in your area for the freshest produce straight from the farm to your table.</p>
                </div>
                
                <div class="feature-card">
                    <span class="feature-icon">🤝</span>
                    <h3>Direct Trade</h3>
                    <p>Cut out the middleman and trade directly with farmers, ensuring fair prices for everyone.</p>
                </div>
                
                <div class="feature-card">
                    <span class="feature-icon">🌍</span>
                    <h3>Sustainable</h3>
                    <p>Support sustainable farming practices and reduce your carbon footprint with local sourcing.</p>
                </div>
                
                <div class="feature-card">
                    <span class="feature-icon">💰</span>
                    <h3>Fair Pricing</h3>
                    <p>Transparent pricing that benefits both farmers and buyers, creating a win-win marketplace.</p>
                </div>
                
                <div class="feature-card">
                    <span class="feature-icon">📱</span>
                    <h3>Easy to Use</h3>
                    <p>User-friendly platform designed for farmers and buyers of all technical backgrounds.</p>
                </div>
                
                <div class="feature-card">
                    <span class="feature-icon">🔒</span>
                    <h3>Secure & Trusted</h3>
                    <p>Safe and secure transactions with verified farmers and buyers in your community.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Active Farmers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">2,000+</div>
                <div class="stat-label">Happy Buyers</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50,000+</div>
                <div class="stat-label">Pounds Traded</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">25</div>
                <div class="stat-label">Cities Served</div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonial-section">
        <div class="testimonial-container">
            <h2 class="testimonial-title">What Our Community Says</h2>
            
            <div class="testimonial-card">
                <p class="testimonial-text">
                    "This platform has revolutionized how I sell my produce. I can now reach customers directly and get fair prices for my hard work!"
                </p>
                <p class="testimonial-author">- Sarah Johnson, Organic Farmer</p>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">
                    "I love being able to buy fresh vegetables directly from local farmers. The quality is amazing and I'm supporting my community!"
                </p>
                <p class="testimonial-author">- Mike Chen, Home Chef</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>We're passionate about connecting local farmers with their communities, promoting sustainable agriculture and fresh, healthy food.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <p><a href="login.php">Login</a></p>
                <p><a href="register.php">Register</a></p>
                <p><a href="#features">Features</a></p>
            </div>
            <div class="footer-section">
                <h3>Contact</h3>
                <p>Email: info@localfarmexchange.com</p>
                <p>Phone: (555) 123-4567</p>
                <p>Address: 123 Farm Street, Green Valley</p>
            </div>
        </div>
        <p style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 2rem; margin-top: 2rem;">
            © 2025 Swasth Ahaar Mand. All rights reserved.
        </p>
    </footer>

    <!-- Scroll to Top Button -->
    <div class="scroll-indicator" onclick="scrollToTop()">
        ↑
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Scroll to top function
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Initialize particles on load
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            
            // Add scroll indicator visibility
            const scrollIndicator = document.querySelector('.scroll-indicator');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    scrollIndicator.style.opacity = '1';
                } else {
                    scrollIndicator.style.opacity = '0';
                }
            });
        });

        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'slideUp 0.8s ease-out forwards';
                }
            });
        }, observerOptions);

        // Observe feature cards
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            featureCards.forEach(card => {
                observer.observe(card);
            });
        });
    </script>

    <?php
   
    
    // If user is already logged in, redirect to their dashboard
    if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'farmer') {
            header("Location: dashboard_farmer.php");
        } elseif ($_SESSION['role'] === 'buyer') {
            header("Location: dashboard_buyer.php");
        }
        exit;
    }
    ?>
</body>
</html>