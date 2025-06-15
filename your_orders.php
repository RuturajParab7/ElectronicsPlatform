<?php
session_start();
include('php/db_connection.php');

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    die("Please log in to view your orders.");
}

$username = $_SESSION['username'];
$conn = new mysqli('localhost', 'root', '', 'product_db');
$stmt = $conn->prepare("SELECT * FROM your_orders WHERE username = ? ORDER BY purchase_date DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='".htmlspecialchars($row['image'])."' alt='".htmlspecialchars($row['name'])."'>";
        echo "<p>".htmlspecialchars($row['name'])." - Rs ".htmlspecialchars($row['price'])."</p>";
        echo "<p>Date: ".$row['purchase_date']."</p>";
        echo "</div>";
    }
} else {
    echo "You have no orders yet.";
}

$stmt->close();
$conn->close();
?>
