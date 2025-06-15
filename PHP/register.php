<?php
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
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    


    $password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO user_registrations (firstname, lastname, username, email, password) 
            VALUES ('$firstname', '$lastname', '$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!'); window.location.href='../login.html';</script>";
    } else {
        if ($conn->errno == 1062) {
            echo "<script>alert('Username or Email already exists.'); window.location.href='../register.html';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "'); window.location.href='../register.html';</script>";
        }
    }

    $conn->close();
}
?>
