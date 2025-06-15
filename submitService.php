<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Escape user inputs for security
    $fullName = $conn->real_escape_string($_POST['fullName']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $device = $conn->real_escape_string($_POST['device']);
    $service = $conn->real_escape_string($_POST['service']);

    // Insert into database
    $sql = "INSERT INTO service_requests (fullName, email, address, date, time, device, service)
            VALUES ('$fullName', '$email', '$address', '$date', '$time', '$device', '$service')";

    if ($conn->query($sql) === TRUE) {
        // Use JavaScript to show an alert and redirect
        echo "<script>
                alert('Service request submitted successfully!');
                window.location.href = 'ServiceForm.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $conn->error . "');
                window.location.href = 'ServiceForm.php';
              </script>";
    }

    // Close connection
    $conn->close();
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href = 'ServiceForm.php';
          </script>";
}
?>
