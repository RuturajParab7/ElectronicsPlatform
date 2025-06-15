<?php
session_start(); // Start the session at the beginning
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amit Enterprises</title>
    
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">
                <img src="images/company.png" alt="Company Logo">
            </div>
            <ul class="navlinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="Aboutus.php">About us</a></li>
                
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
    

    <div class="ad">
        <img src="images/ad1.png" alt="Advertisement">
    </div>

    <div class="p_header">
        <h1>CORE PRODUCTS</h1>
    </div>

    <div class="prod_links">
        <div class="prod_item">
            <a href="NewWM.php" class="wm_link">
                <img src="images/WM1.jpg" alt="Washing Machine">
            </a>
            <p class="pLabel">Smart Washing Machines</p>
        </div>

        <div class="prod_item">
            <a href="NewAC.php" class="ac_link">
                <img src="images/AC1.png" alt="Air Conditioner">
            </a>
            <p class="pLabel">Smart Air Conditioners</p>
        </div>

        <div class="prod_item">
            <a href="NewFridge.php" class="fridge_link">
                <img src="images/FRIDGE.png" alt="Refrigerator">
            </a>
            <p class="pLabel">Smart Refrigerators</p>
        </div>
    </div>

    <div class="p_header">
        <h1>OUR SERVICES</h1>
    </div>


    <!-- Services List with Pricing -->
    <div class="services_container">
        <div class="service_category">
        <a href="services.php" class="service_link">
            <h2>Air Conditioner Services</h2>
            <ul>
                <li>Gas Charging - ₹1,500</li>
                <li>Jet Pump Service - ₹1,200</li>
                <li>Normal Water Wash - ₹500</li>
                <li>Installation - ₹800</li>
                <li>Uninstallation - ₹600</li>
                <li>Regular Service - ₹1,000</li>
            </ul>
            </a>
        </div>
        
        <div class="service_category">
        <a href="services.php" class="service_link">
            <h2>Fridge Services</h2>
            <ul>
                <li>Gas Charging - ₹1,800</li>
                <li>Normal Repairing - ₹1,200</li>
                <li>Demo - ₹300</li>
                <li>Installation - ₹500</li>
                <li>Less Cooling - ₹1,000</li>
                <li>Extra Frost - ₹700</li>
            </ul>
            </a>
        </div>
        
        <div class="service_category">
        <a href="services.php" class="service_link">
            <h2>Washing Machine Services</h2>
            <ul>
                <li>Drum Cleaning - ₹1,000</li>
                <li>Demo - ₹300</li>
                <li>Dashboard Repair - ₹2,000</li>
                <li>Regular Service - ₹1,200</li>
                <li>Other - ₹800</li>
            </ul>
            </a>
        </div>
    </div>

    <footer class="footer">
    <div class="footer_container">
        <div class="footer_section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.html">View Cart</a></li>
            </ul>
        </div>

        <div class="footer_section">
            <h3>Products</h3>
            <ul>
                <li><a href="NewWM.php">Washing Machines</a></li>
                <li><a href="NewAC.php">Air Conditioners</a></li>
                <li><a href="NewFridge.php">Refrigerators</a></li>
            </ul>
        </div>

        <div class="footer_section">
            <h3>Contact Us</h3>
            <p>Email: amitprb63@gmail.com</p>
            <p>Phone: +91-9821269110</p>
            <p>Address: C10 Madhuri CHS,Gunsagar nagar.Kalwa(w)</p>
        </div>

        <div class="footer_section">
            <h3>Follow Us</h3>
            <ul class="social_links">
                <li><a href="https://www.instagram.com/ruturaj_prb_7/" class="social_icon">Instagram</a></li>
                <li><a href="https://www.facebook.com/login.php/" class="social_icon">Facebook</a></li>
                <li><a href="https://www.linkedin.com/in/ruturaj-parab-61a379314/" class="social_icon">LinkedIn</a></li>
            </ul>
        </div>
    </div>
    <div class="footer_bottom">
        <p>&copy; 2024 Amit Enterprises. All rights reserved.</p>
    </div>
</footer>


<script>
        // Check if the user logged out
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('logged_out')) {
            // Clear the cart in local storage
            localStorage.removeItem('cart');
        }
    </script>
    
    
</body>
</html>
