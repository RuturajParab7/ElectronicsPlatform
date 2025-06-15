<?php
// Include database connection
include('../php/db_connection.php');  // Adjust path based on your project structure

// Check if an 'id' is provided via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare and execute the query to fetch air conditioner data
    $sql = "SELECT * FROM air_conditioners WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the row data as an associative array
        $row = $result->fetch_assoc();
        
        // Return the data as JSON
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No air conditioner found with the provided ID']);
    }

    // Close the statement
    $stmt->close();
} else {
    echo json_encode(['error' => 'No ID provided']);
}

// Close the database connection
$conn->close();
?>
