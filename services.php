<?php
session_start(); // Start the session at the beginning
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service support</title>
    
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
      <div class="Serv_ad">
        <img src="images/posterServices.png">
      </div>

      <div class="book_service">
        <p class="book_servText">BOOK SERVICES FOR YOUR PRODUCTS</p>
        <div class="blue_line"></div>
      </div>

      <div class="service_container">
        <!-- Service Boxes -->
        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/services_Jetpump.png" alt="AC Jet Pump Service">
                </div>
                <h3>Jet Pump Service</h3>
                <p>High pressure water cleaning for outdoor and indoor device for better cooling.</p>
            </a>
        </div>


        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/services_wash.png" alt="Normal Water Wash Service">
                </div>
                <h3>Normal Water Wash</h3>
                <p>Thorough water wash service for all appliances to keep them clean and efficient.</p>
            </a>
        </div>


        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/services_install.png" alt="Installation & Uninstallation">
                </div>
                <h3>Installation & Uninstallation</h3>
                <p>Installing and uninstalling your devices professionally with proper demo for usage.</p>
            </a>
        </div>


        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/services_gascharge.png" alt="Refrigerator Gas Charging">
                </div>
                <h3>Gas Charging</h3>
                <p>Ensure your refrigerator and ac are working efficiently with the help of gas charging.</p>
            </a>
        </div>


        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/service_repair.png" alt="Normal Repair Service">
                </div>
                <h3>Normal Repair</h3>
                <p>Regular repair services for your devices to address common issues.</p>
            </a>
        </div>


        <div class="service_box">
            <a href="ServiceForm.php" class="service_link">
                <div class="service_img">
                    <img src="images/services_drum.png" alt="Washing Machine Drum Cleaning">
                </div>
                <h3>Washing Machine Drum Cleaning</h3>
                <p>Deep cleaning for your washing machine drum to maintain its efficiency.</p>
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
</body>
</html>