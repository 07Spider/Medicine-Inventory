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
$billquantity = isset($_GET['billquantity']) ? $_GET['billquantity'] : '';
$strate = isset($_GET['rate']) ? $_GET['rate'] : '';
$stsellmedicine = isset($_GET['sellmedicine']) ? $_GET['sellmedicine'] : '';

if ($eid && $name && $brand && $stquantity && $billquantity && $strate && $stsellmedicine) {
    // Parse and calculate values
    $quantity = intval($stquantity);
    $rate = floatval($strate);
    $newquantity = intval($stsellmedicine);
    $addnewQuantity = $quantity - $newquantity;
    $intbillquantity = intval($billquantity);

    $billtotal = $intbillquantity * $rate;
    $total = $addnewQuantity * $rate;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            color: #00695c;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #80cbc4;
            border-radius: 8px;
        '>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Update the medicine record
    $updateStmt = $conn->prepare("UPDATE med SET name = ?, brand = ?, quantity = ?, rate = ?, total = ? WHERE id = ?");
    $updateStmt->bind_param("ssiddi", $name, $brand, $addnewQuantity, $rate, $total, $eid);
    $rowsUpdated = 0;
    if ($updateStmt->execute()) {
        $rowsUpdated = $updateStmt->affected_rows;
    }
    $updateStmt->close();

    // Insert into bill table
    $stmt = $conn->prepare("INSERT INTO bill (name, brand, quantity, rate, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidd", $name, $brand, $intbillquantity, $rate, $billtotal);
    $inserted = $stmt->execute();
    $stmt->close();

    if ($rowsUpdated > 0 && $inserted) {
        // Redirect to index.html after successful update and insert
        header("Location: index.html");
        exit();
    } else {
        echo "<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            color: #00695c;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #80cbc4;
            border-radius: 8px;
        '><h2>Record not found or update/insert failed.</h2></div>";
    }

    $conn->close();
} else {
    echo "<div style='
        font-family: Arial, sans-serif;
        background-color: #e0f2f1;
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
