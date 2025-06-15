<?php
// Start the session
session_start();

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

// Fetch registered users
$sql = "SELECT id, firstname, lastname, username, email FROM user_registrations";
$result = $conn->query($sql);

// Fetch service orders
$service_sql = "SELECT * FROM service_requests ORDER BY created_at DESC";
$service_result = $conn->query($service_sql);

// Remove service order if requested
if (isset($_POST['remove'])) {
    $orderId = $_POST['order_id'];
    $delete_sql = "DELETE FROM service_requests WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();
    
    // Refresh the page after deletion
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .navbar {
            background-color: #333;
            color: white;       
            padding: 10px 20px;
            text-align: center;
        }
        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #333;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .navbar-links {
            display: inline-block;
            margin-left: 900px;
        }
        .navbar-links a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar-links a:hover {
            text-decoration: underline;
        }
        .btn-remove {
            background-color: red;
            color: white;
            padding: 6px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .btn-remove:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Admin Dashboard</h1>
    <div class="navbar-links">
        <a href="admin_dashboard.php">Dashboard</a> 
        <a href="Admin_ac.php">AC</a>  
        <a href="Admin_ref.php">Refrigerators</a>  
        <a href="Admin_wm.php">WM</a>
    </div>
</div>

<div class="content">
    <h2>Registered Users</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data for each user
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Service Orders</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Date</th>
                <th>Time</th>
                <th>Device</th>
                <th>Service</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($service_result->num_rows > 0) {
                // Output data for each service request
                while ($service_row = $service_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($service_row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['fullName']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['device']) . "</td>";
                    echo "<td>" . htmlspecialchars($service_row['service']) . "</td>";
                    echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='order_id' value='" . $service_row['id'] . "' />
                            <button type='submit' name='remove' class='btn-remove'>Remove</button>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No service orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
