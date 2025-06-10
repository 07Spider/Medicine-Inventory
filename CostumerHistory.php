<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get parameters from GET request
$name = isset($_GET['name']) ? $_GET['name'] : '';
$drname = isset($_GET['drname']) ? $_GET['drname'] : '';
$sttotal = isset($_GET['total']) ? $_GET['total'] : '';
$sttime = isset($_GET['time']) ? $_GET['time'] : '';

if ($name && $drname && $sttotal && $sttime) {
    $inttotal = floatval($sttotal);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            color: #004d40;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
        '>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Delete all records from bill table
    $deleteStmt = $conn->prepare("DELETE FROM bill");
    $deleteStmt->execute();
    $deleteStmt->close();

    // Insert into history table
    $stmt = $conn->prepare("INSERT INTO history ( name, drname, brand, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $drname, $inttotal, $sttime);

    if ($stmt->execute()) {
        // Redirect to index.html on success
        header("Location: try1.html");
        exit();
    } else {
        echo "<div style='
            font-family: Arial, sans-serif;
            background-color: #ffebee;
            color: #c62828;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #ef9a9a;
            border-radius: 8px;
        '>Data insertion failed: " . htmlspecialchars($stmt->error) . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div style='
        font-family: Arial, sans-serif;
        background-color: #fff3e0;
        color: #e65100;
        padding: 20px;
        text-align: center;
        margin: 40px auto;
        width: 60%;
        border: 1px solid #ffcc80;
        border-radius: 8px;
    '>Missing required parameters.</div>";
}
?>
