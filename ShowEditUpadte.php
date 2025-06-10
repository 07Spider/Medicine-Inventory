<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get parameters from GET request
$eid = isset($_GET['eid']) ? $_GET['eid'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$stquantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';
$strate = isset($_GET['rate']) ? $_GET['rate'] : '';

// Ensure all required parameters are present
if ($eid && $name && $brand && $stquantity && $strate) {
    // Validate quantity and rate (ensure they are numbers)
    if (is_numeric($stquantity) && is_numeric($strate)) {
        $quantity = intval($stquantity);
        $rate = floatval($strate);
        $total = $quantity * $rate;

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("UPDATE med SET name = ?, brand = ?, quantity = ?, rate = ?, total = ? WHERE id = ?");
        $stmt->bind_param("ssiddi", $name, $brand, $quantity, $rate, $total, $eid);

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            // Redirect to Show.php after successful update
            header("Location: Show.php");
            exit();
        } else {
            echo "<h2>Record not found or update failed.</h2>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<h2>Quantity and Rate must be numeric values.</h2>";
    }
} else {
    echo "<h2>Missing required parameters. Please ensure all fields are filled in.</h2>";
}
?>
