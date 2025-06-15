<?php
session_start();
include('php/db_connection.php');

// Ensure the user is an admin
/*if ($_SESSION['role'] != 'admin') {
    die("Access denied.");
}*/

$conn = new mysqli('localhost', 'root', '', 'product_db');
$result = $conn->query("SELECT * FROM admin_purchases ORDER BY purchase_date DESC");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<img src='".htmlspecialchars($row['image'])."' alt='".htmlspecialchars($row['name'])."'>";
        echo "<p>".htmlspecialchars($row['name'])." - Rs ".htmlspecialchars($row['price'])."</p>";
        echo "<p>Purchased by: ".htmlspecialchars($row['purchased_by'])."</p>";
        echo "<p>Date: ".$row['purchase_date']."</p>";
        echo "</div>";
    }
} else {
    echo "No purchases yet.";
}

$conn->close();
?>
