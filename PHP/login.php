<?php
session_start(); // Start the session

$_SESSION['username'] = $username;  // Store username in session



// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "amit_enterprises";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Retrieve user data
    $sql = "SELECT * FROM user_registrations WHERE username='$username' AND email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store username in session
            $_SESSION['username'] = $row['username'];

            // Check if user is admin
            if ($row['email'] === 'amitprb63@gmail.com') {
                // Redirect to admin dashboard if admin
                echo "<script>alert('Admin login successful!'); window.location.href='../admin/admin_dashboard.php';</script>";
            } else {
                // Redirect to index.php for regular users
                echo "<script>alert('Login successful!'); window.location.href='../index.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location.href='../login.html';</script>";
        }
    } else {
        echo "<script>alert('No user found'); window.location.href='../login.html';</script>";
    }

    $conn->close();
}
?>
