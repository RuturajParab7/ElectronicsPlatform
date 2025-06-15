<?php
session_start();
include('php/db_connection.php'); // Include the database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Air Conditioners</title>
    
    <link rel="stylesheet" href="css/footer.css">
    <!--<link rel="stylesheet" href="CSS/ProductsDisplay.css">-->
    <style>
        .prod_links {
            display: flex;
            justify-content: center;
            padding: 30px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 items per row */
            gap: 20px; /* Spacing between items */
        }

        .prod_item {
            border: 1px solid #ccc; /* Added a subtle border for definition */
            padding: 20px; /* Reduced padding to avoid excessive space */
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 10px; /* Added border-radius for rounded corners */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Added shadow for better separation */
        }

        .prod_item img {
            width: 240px; /* Set a fixed width for consistent image size */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Added space below the image */
        }


        .pLabel {
            font-size: 16px;
            font-weight: bold;
            color: #333; /* Changed text color for better contrast */
            margin-bottom: 5px; /* Added space below the label */
        }

        /* Changed here: Price styling for emphasis */
        .pPrice {
            font-size: 18px;
            color: #000; /* Made the price color black for visibility */
        }

        .blue_line{
            width: 50%;
            height: 7px;
            background-color: blue;
            margin: -10px auto 0;
        }

        a {
    text-decoration: none;
        }
    </style>
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
        <img src="images/acPgAd.png" alt="Advertisement">
    </div>

    <div class="p_header">
        <h1>STAY COOL IN ANY WEATHER WITH OUR ENERGY EFFICIENT AIR CONDITIONERS</h1>
    </div>
    <div class="blue_line"></div>

    <div class="prod_links">
        <div class="product-grid">
            <?php
            // Fetch products from the database
            $conn = new mysqli('localhost', 'root', '', 'product_db');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM air_conditioners";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="prod_item">';
                    echo '<a href="NewACDetails.php?id=' . htmlspecialchars($row['id']) . '">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<p class="pLabel">' . htmlspecialchars($row['name']) . '</p>';
                    echo '<p class="pPrice">MRP: RS ' . htmlspecialchars($row['price']) . '</p>';
                    echo '</a>'; // Closing the anchor tag
                    echo '</div>';
                }
            } else {
                echo 'No products found.';
            }

            $conn->close();
            ?>
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
