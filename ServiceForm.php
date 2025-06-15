<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to login page
    header("Location: login.html");
    exit(); // Stop further execution of the page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Form</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="CSS/serviceForm.css">
    <script>
        function updateServiceOptions() {
            var device = document.getElementById("device").value;
            var serviceSelect = document.getElementById("service");

            var services = {
                "Air conditioner": ["Gas Charging", "Jet Pump Service", "Normal Water Wash", "Installation", "Uninstallation", "Regular Service"],
                "Fridge": ["Gas Charging", "Normal Repairing", "Demo", "Installation", "Less Cooling", "Extra Frost"],
                "Washing machine": ["Drum Cleaning", "Demo", "Dashboard Repair", "Regular Service", "Other"]
            };

            serviceSelect.innerHTML = "";
            if (device in services) {
                services[device].forEach(function(service) {
                    var option = document.createElement("option");
                    option.value = service;
                    option.textContent = service;
                    serviceSelect.appendChild(option);
                });
            } else {
                serviceSelect.innerHTML = "<option value='' disabled selected>Select a service</option>";
            }
        }

        // Client-side validation
        function validateForm() {
            var fullName = document.getElementById("fullName").value;
            var email = document.getElementById("email").value;
            var address = document.getElementById("address").value;
            var device = document.getElementById("device").value;
            var nameRegex = /^[A-Za-z\s]+$/; // Only alphabets and spaces
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            // Full Name Validation
            if (!nameRegex.test(fullName)) {
                alert("Full name can only contain letters and spaces.");
                return false;
            }

            // Email Validation
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address (e.g., user@domain.com).");
                return false;
            }

            // Address Validation
            if (address.trim() === "") {
                alert("Address cannot be empty.");
                return false;
            }

            // Device Selection Validation
            if (device === "") {
                alert("Please select a device.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <nav class="navbar">
        <!-- Your navbar content here -->
    </nav>

    <div class="service-form-container">
        <h2>Book a Service</h2>
        <form action="submitService.php" method="post" onsubmit="return validateForm()">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="date">Date of Service:</label>
            <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time">

            <label for="device">Select Device:</label>
            <select id="device" name="device" onchange="updateServiceOptions()" required>
                <option value="" disabled selected>Select your device</option>
                <option value="Air conditioner">Air Conditioner</option>
                <option value="Fridge">Refrigerator</option>
                <option value="Washing machine">Washing Machine</option>
            </select>

            <label for="service">Service Required:</label>
            <select id="service" name="service" required>
                <option value="" disabled selected>Select a service</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
