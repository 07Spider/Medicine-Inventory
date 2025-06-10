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
$stnewmedicine = isset($_GET['newmedicine']) ? $_GET['newmedicine'] : '';

if ($eid && $name && $brand && $stquantity && $strate && $stnewmedicine) {
    $quantity = intval($stquantity);
    $rate = floatval($strate);
    $newquantity = intval($stnewmedicine);

    $addnewQuantity = $newquantity + $quantity;
    $total = $addnewQuantity * $rate;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("UPDATE med SET name = ?, brand = ?, quantity = ?, rate = ?, total = ? WHERE id = ?");
    $stmt->bind_param("ssiddi", $name, $brand, $addnewQuantity, $rate, $total, $eid);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Redirect to history after successful update
        header("Location: history");
        exit();
    } else {
        echo "<div style='
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            color: #004d40;
            padding: 20px;
            text-align: center;
            margin: 40px auto;
            width: 60%;
            border: 1px solid #b2dfdb;
            border-radius: 8px;
        '>
            <h2>Record not found or update failed.</h2>
        </div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div style='
        font-family: Arial, sans-serif;
        background-color: #fff3e0;
        color: #bf360c;
        padding: 20px;
        text-align: center;
        margin: 40px auto;
        width: 60%;
        border: 1px solid #ffccbc;
        border-radius: 8px;
    '>
        <h2>Missing required parameters.</h2>
    </div>";
}
?>
