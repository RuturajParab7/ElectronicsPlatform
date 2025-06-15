<?php
// Start the session
session_start();

// Include database connection
include('../php/db_connection.php');  // Adjust path based on your directory structure

// Initialize variables for form fields
$id = 0;
$name = '';
$brand = '';
$price = '';
$specifications = '';
$extra_info = '';
$image = '';

// Handle form submissions for adding or updating products
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $specifications = $_POST['specifications'];
    $extra_info = $_POST['extra_info'];
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = 'images/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
    }

    if ($id) {
        // Update existing record
        $sql = "UPDATE washing_machines SET name=?, brand=?, image=?, price=?, specifications=?, extra_info=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $name, $brand, $image, $price, $specifications, $extra_info, $id);
    } else {
        // Add new record
        $sql = "INSERT INTO washing_machines (name, brand, image, price, specifications, extra_info) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssiss", $name, $brand, $image, $price, $specifications, $extra_info);
    }
    
    if ($stmt->execute()) {
        echo "Record successfully " . ($id ? "updated" : "added") . ".";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Handle deletion
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM washing_machines WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Record deleted.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Handle editing
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $sql = "SELECT * FROM washing_machines WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Prepopulate the form with the existing data
        $name = $row['name'];
        $brand = $row['brand'];
        $price = $row['price'];
        $specifications = $row['specifications'];
        $extra_info = $row['extra_info'];
        $image = $row['image'];
        $id = $row['id'];
    }
    $stmt->close();
}

// Fetch washing machines data
$sql = "SELECT * FROM washing_machines";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Washing Machines</title>
    <link rel="stylesheet" href="../css/styles.css">  <!-- Adjust CSS path if needed -->
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
        .navbar nav a {
            color: #6a5acd; 
            text-decoration: none; 
            padding: 5px 15px; 
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
        img {
            width: 100px;
            height: auto;
        }
        .form-container {
            margin: 20px 0;
        }
        .form-container input, .form-container textarea {
            display: block;
            margin: 10px 0;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-container input[type="file"] {
            padding: 0;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Admin - Washing Machines</h1>
    <nav>
    <a href="admin_dashboard.php">Dashboard</a> | 
        <a href="Admin_ac.php">Air Conditioners</a> | 
        <a href="Admin_ref.php">Refrigerators</a> | 
        <a href="Admin_wm.php">Washing Machines</a>
    </nav>
</div>

<div class="content">
    <!-- Table to display washing machines -->
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Image</th>
            <th>Price</th>
            <th>Specifications</th>
            <th>Extra Info</th>
            <th>Action</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><img src="../<?php echo $row['image']; ?>" alt="Image"></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['specifications']; ?></td>
                    <td><?php echo $row['extra_info']; ?></td>
                    <td>
                        <a href="?edit=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No washing machines found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Form to add or update washing machines -->
    <div class="form-container">
        <form action="Admin_wm.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
            
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" value="<?php echo $brand; ?>" required>
            
            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" value="<?php echo $price; ?>" required>
            
            <label for="specifications">Specifications:</label>
            <textarea name="specifications" id="specifications" required><?php echo $specifications; ?></textarea>
            
            <label for="extra_info">Extra Information:</label>
            <textarea name="extra_info" id="extra_info"><?php echo $extra_info; ?></textarea>
            
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" <?php echo empty($id) ? 'required' : ''; ?>>
            
            <button type="submit"><?php echo $id ? 'Update Washing Machine' : 'Add Washing Machine'; ?></button>
        </form>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
