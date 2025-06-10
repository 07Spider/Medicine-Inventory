<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get parameters from GET request
$name = isset($_GET['name']) ? $_GET['name'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$stquantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';
$strate = isset($_GET['rate']) ? $_GET['rate'] : '';

if ($name && $brand && $stquantity && $strate) {
    $quantity = intval($stquantity);
    $rate = floatval($strate);
    $total = $quantity * $rate;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            color: #00695c;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #80cbc4;
            border-radius: 8px;
        '>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO med (name, brand, quantity, rate, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidd", $name, $brand, $quantity, $rate, $total);

    if ($stmt->execute()) {
        // Redirect to index.html on success
        header("Location: index.html");
        exit();
    } else {
        echo "<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
            color: #00695c;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #80cbc4;
            border-radius: 8px;
        '>Data insertion failed: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div style='
        font-family: Arial, sans-serif;
        background-color: #e0f7fa;
        color: #00695c;
        padding: 20px;
        text-align: center;
        margin: 40px auto;
        width: 60%;
        border: 1px solid #80cbc4;
        border-radius: 8px;
    '>Missing required parameters.</div>";
}
?>
