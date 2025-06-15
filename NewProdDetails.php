<?php
session_start();
include('php/db_connection.php'); // Include the database connection file

// Get the product ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Invalid product ID.");
}

$conn = new mysqli('localhost', 'root', '', 'product_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$stmt = $conn->prepare("SELECT * FROM washing_machines WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Amit Enterprises</title>
    
    <link rel="stylesheet" href="css/footer.css">

    <style>
        /* General styles */
        body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

/* Navbar styles */


/* Product Details styles */
.prod_details {
    display: flex;
    justify-content: space-between;
    padding: 40px 20px;
    max-width: 1200px;
    margin: auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
    margin-top: 20px;
}

.prod_image {
    width: 35%;
}

.prod_info {
    width: 60%;
    padding-left: 20px;
}

.prod_image img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.pLabel {
    font-size: 36px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.pPrice {
    font-size: 28px;
    color: #007BFF;
    margin-bottom: 20px;
}

.pSpecs {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
}

.extra_info {
    margin-top: 20px;
    font-size: 18px;
    color: #666;
}

.btn {
    background-color: #007BFF;
    color: white;
    font-size: 18px;
    padding: 15px 25px;
    margin: 10px 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
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

<div class="prod_details">
    <div class="prod_image">
        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="prod_info">
        <p class="pLabel"><?php echo htmlspecialchars($product['name']); ?></p>
        <p class="pPrice">Rs <?php echo htmlspecialchars($product['price']); ?></p>
        <p class="pSpecs"><?php echo htmlspecialchars($product['specifications']); ?></p>
        <div class="extra_info">
            <?php echo nl2br(htmlspecialchars($product['extra_info'])); ?>
        </div>
        <button class="btn" id="add-to-cart-btn">Add to Cart</button>
        <button class="btn" id="buy-now-btn">Buy Now</button>
        
    </div>
</div>



<script>
    document.getElementById('add-to-cart-btn').addEventListener('click', () => {
        // Product details
        const product = {
            id: <?php echo $product['id']; ?>,
            name: "<?php echo addslashes($product['name']); ?>",
            image: "<?php echo addslashes($product['image']); ?>",
            price: <?php echo $product['price']; ?>
        };

        // Get cart from local storage or initialize as empty array
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        // Check if product is already in the cart
        const existingProductIndex = cart.findIndex(item => item.id === product.id);

        if (existingProductIndex === -1) {
            // Add product to cart
            cart.push(product);
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Product added to cart successfully!');
        } else {
            alert('Product is already in the cart.');
        }
    });

    document.getElementById('buy-now-btn').addEventListener('click', () => {
    // Store product details in session (or pass via URL)
    window.location.href = `payement.html?id=<?php echo $product['id']; ?>&type=washing_machines`;
});



</script>

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
