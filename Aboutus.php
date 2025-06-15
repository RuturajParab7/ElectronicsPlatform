<?php
session_start(); // Start the session at the beginning
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Amit Enterprises</title>
    <link rel="stylesheet" href="CSS/aboutUs.css">
   
    <link rel="stylesheet" href="css/footer.css">
    
</head>
<body>

    <!-- Navbar Section -->
    <header>
        <nav class="navbar">
            <div class="navbar-container">
                <div class="logo">
                    <img src="images/company.png" alt="Company Logo">
                </div>
                <ul class="navlinks">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="aboutUs.php">About Us</a></li>
                    <li><a href="cart.html">View Cart</a></li>
                    <?php
                if (isset($_SESSION['username'])) {
                    echo '<li class="username">Welcome, ' . htmlspecialchars($_SESSION['username']) . '</li>';
                    echo '<li><a href="PHP/logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.html">Login</a></li>';
                }
                ?>
                </ul>
            </div>
        </nav>
    </header>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="about-container">
            <div class="about-content">
                <h1>About Amit Enterprises</h1>
                <p>Welcome to Amit Enterprises, where we strive to bring the latest and most reliable home appliances to our customers. From top-quality air conditioners to the most efficient washing machines and refrigerators, we are dedicated to providing excellent products and services that make your life easier.</p>
                <p>Founded in 2001, Amit Enterprises has grown into a trusted name in the home appliance industry. We are passionate about delivering value, innovation, and customer satisfaction in every product we offer.</p>
            </div>
            <div class="about-image">
                <img src="IMAGES/About.png" >
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="mission-section">
        <div class="mission-container">
            <div class="mission-content">
                <h2>Our Mission</h2>
                <p>At Amit Enterprises, our mission is simple – to enhance the comfort and quality of life of our customers by offering high-performance and energy-efficient home appliances. We are committed to innovation and providing solutions that meet your everyday needs.</p>
            </div>
        </div>
    </section>

    <!-- Meet Our Team Section -->
    <section class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member">
                <h3>Amit Parab</h3>
                <p>CEO & Founder</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member">
                <h3>Ruturaj Parab</h3>
                <p>CTO</p>
            </div>
            <div class="team-member">
                <img src="https://via.placeholder.com/150" alt="Team Member">
                <h3>Apurva Parab</h3>
                <p>Lead Engineer</p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Amit Enterprises. All Rights Reserved.</p>
    </footer>

</body>
</html>
