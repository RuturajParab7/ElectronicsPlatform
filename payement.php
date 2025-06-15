<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

include('php/db_connection.php'); // Database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form input and sanitize
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zip_code = htmlspecialchars($_POST['zip_code']);
    $card_name = htmlspecialchars($_POST['card_name']);
    $card_number = htmlspecialchars($_POST['card_number']);
    $exp_month = htmlspecialchars($_POST['exp_month']);
    $exp_year = htmlspecialchars($_POST['exp_year']);
    $cvv = htmlspecialchars($_POST['cvv']);

    // Hash sensitive data (card number and CVV)
    $card_number_hash = password_hash($card_number, PASSWORD_DEFAULT);
    $cvv_hash = password_hash($cvv, PASSWORD_DEFAULT);

    // Get the logged-in user's username
    $username = $_SESSION['username'];

    // Insert the order details into the database
    $sql = "INSERT INTO orders (username, full_name, email, address, city, state, zip_code, card_name, card_number_hash, exp_month, exp_year, cvv_hash) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssssis', $username, $full_name, $email, $address, $city, $state, $zip_code, $card_name, $card_number_hash, $exp_month, $exp_year, $cvv_hash);

    if ($stmt->execute()) {
        echo "<script>alert('Payment Successful! Your order has been placed.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('There was an issue processing your payment. Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>








<!--
</-------?php
session_start();
include('php/db_connection.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    die("You must be logged in to complete the purchase.");
}

// Initialize variables for product details
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product_type = isset($_GET['type']) ? $_GET['type'] : '';

// Validate product type
$valid_types = ['air_conditioners', 'washing_machines', 'refrigerators'];
if (!in_array($product_type, $valid_types)) {
    die("Invalid product type.");
}

// Fetch product details from the database
$conn = new mysqli('localhost', 'root', '', 'product_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT name, image, price FROM $product_type WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Product not found.");
}

$username = $_SESSION['username'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $fullName = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zipCode = htmlspecialchars($_POST['zip_code']);
    $cardName = htmlspecialchars($_POST['card_name']);
    $cardNumber = htmlspecialchars($_POST['card_number']);
    $expMonth = htmlspecialchars($_POST['exp_month']);
    $expYear = htmlspecialchars($_POST['exp_year']);
    $cvv = htmlspecialchars($_POST['cvv']);
    
    // Hash the card number and CVV
    $hashedCardNumber = password_hash($cardNumber, PASSWORD_DEFAULT);
    $hashedCVV = password_hash($cvv, PASSWORD_DEFAULT);
    
    // Insert purchase into admin_purchases
    $stmt = $conn->prepare("INSERT INTO admin_purchases (product_id, product_type, name, image, price, purchased_by, full_name, email, address, city, state, zip_code, card_name, card_number, exp_month, exp_year, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssssssss", $product_id, $product_type, $product['name'], $product['image'], $product['price'], $username, $fullName, $email, $address, $city, $state, $zipCode, $cardName, $hashedCardNumber, $expMonth, $expYear, $hashedCVV);
    
    if (!$stmt->execute()) {
        die("Error inserting into admin purchases: " . $stmt->error);
    }

    // Insert purchase into user's orders (your_orders table)
    $stmt = $conn->prepare("INSERT INTO your_orders (username, product_id, product_type, name, image, price, full_name, email, address, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssssssss", $username, $product_id, $product_type, $product['name'], $product['image'], $product['price'], $fullName, $email, $address, $city, $state, $zipCode);
    
    if (!$stmt->execute()) {
        die("Error inserting into user orders: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    // Redirect to success page
    header("Location: postBuy.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Payment Page</title>
</head>
<body>

<div class="container">
    <h2>Purchase: </----------?php echo htmlspecialchars($product['name']); ?></h2>
    <form method="POST" action="payement.php?id=</----------?php echo $product_id; ?>&type=</----------?php echo $product_type; ?>">
        <div class="row">
            <div class="col">
                <h3 class="title">Billing Address</h3>
                <div class="inputBox">
                    <span>Full Name :</span>
                    <input type="text" name="full_name" placeholder="Enter your name" required>
                </div>
                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" name="email" placeholder="email@gmail.com" required>
                </div>
                <div class="inputBox">
                    <span>Address :</span>
                    <input type="text" name="address" placeholder="Enter your address" required>
                </div>
                <div class="inputBox">
                    <span>City :</span>
                    <input type="text" name="city" placeholder="Enter city name" required>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>State :</span>
                        <input type="text" name="state" placeholder="Enter state" required>
                    </div>
                    <div class="inputBox">
                        <span>Zip Code :</span>
                        <input type="text" name="zip_code" placeholder="123 456" required>
                    </div>
                </div>
            </div>

            <div class="col">
                <h3 class="title">Payment</h3>
                <div class="inputBox">
                    <span>Cards Accepted :</span>
                    <img src="images/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>Name on Card :</span>
                    <input type="text" name="card_name" placeholder="Mr. XYZ" required>
                </div>
                <div class="inputBox">
                    <span>Credit Card Number :</span>
                    <input type="number" name="card_number" placeholder="1234-5678-91" required>
                </div>
                <div class="inputBox">
                    <span>Exp Month :</span>
                    <input type="text" name="exp_month" placeholder="Expiry month" required>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Exp Year :</span>
                        <input type="number" name="exp_year" placeholder="Exp year" required>
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" name="cvv" placeholder="1234" required>
                    </div>
                </div>
            </div>
        </div>
        <input type="submit" value="Proceed to Checkout" class="submit-btn">
    </form>
</div>
</body>
</html>
-->
