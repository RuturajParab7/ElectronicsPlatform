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
    } else {
        // Keep existing image if no new image is uploaded
        $image = $_POST['existing_image'] ?? '';
    }

    if ($id) {
        // Update existing record
        $sql = "UPDATE air_conditioners SET name=?, brand=?, image=?, price=?, specifications=?, extra_info=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissi", $name, $brand, $image, $price, $specifications, $extra_info, $id);
    } else {
        // Add new record
        $sql = "INSERT INTO air_conditioners (name, brand, image, price, specifications, extra_info) VALUES (?, ?, ?, ?, ?, ?)";
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
    $sql = "DELETE FROM air_conditioners WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Record deleted.";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

// Fetch air conditioner data
$sql = "SELECT * FROM air_conditioners";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Air Conditioners</title>
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
            color: #6a5acd; /* Change this color to a visible color */
            text-decoration: none; /* Remove underline */
            padding: 5px 15px; /* Add padding */
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
    <h1>Admin - Air Conditioners</h1>
    <nav>
        <a href="admin_dashboard.php">Dashboard</a> | 
        <a href="Admin_ac.php">Air Conditioners</a> | 
        <a href="Admin_ref.php">Refrigerators</a> | 
        <a href="Admin_wm.php">Washing Machines</a>
    </nav>
</div>

<div class="content">
    <h2>Manage ACs</h2>
    
    <!-- Form for Adding/Updating Products -->
    <div class="form-container">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="product_id" value="<?php echo $id; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $image; ?>">
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
            
            <label for="brand">Brand:</label>
            <input type="text" name="brand" id="brand" value="<?php echo htmlspecialchars($brand); ?>" required>
            
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
            
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>
            
            <label for="specifications">Specifications:</label>
            <textarea name="specifications" id="specifications" required><?php echo htmlspecialchars($specifications); ?></textarea>
            
            <label for="extra_info">Extra Info:</label>
            <textarea name="extra_info" id="extra_info"><?php echo htmlspecialchars($extra_info); ?></textarea>
            
            <button type="submit"><?php echo $id ? 'Update AC' : 'Add AC'; ?></button>
        </form>
    </div>
    
    <!-- Table of Existing Air Conditioners -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Image</th>
                <th>Price</th>
                <th>Specifications</th>
                <th>Extra Info</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                    echo "<td><img src='../" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' /></td>";
                    echo "<td>₹" . htmlspecialchars($row['price']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['specifications']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['extra_info']) . "</td>";
                    echo "<td><a href='?edit=" . htmlspecialchars($row['id']) . "'>Edit</a> | <a href='?delete=" . htmlspecialchars($row['id']) . "' onclick=\"return confirm('Are you sure you want to delete this item?')\">Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No air conditioners found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Populate the form with existing product data for editing
    <?php if (isset($_GET['edit'])): ?>
    const editId = <?php echo intval($_GET['edit']); ?>;
    document.addEventListener('DOMContentLoaded', function() {
        fetch(`fetch_ac.php?id=${editId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('product_id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('brand').value = data.brand;
                document.getElementById('price').value = data.price;
                document.getElementById('specifications').value = data.specifications;
                document.getElementById('extra_info').value = data.extra_info;
                if (data.image) {
                    document.getElementById('existing_image').value = data.image;
                }
            });
    });
    <?php endif; ?>
</script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
