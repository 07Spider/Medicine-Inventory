<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get the id parameter from the GET request
$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id !== '') {
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

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirect to ShowCart.php if deletion was successful
        header("Location: ShowCart.php");
        exit();
    } else {
        // Redirect to Show.php if no rows were deleted
        header("Location: Show.php");
        exit();
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
        border: 1px solid #4db6ac;
        border-radius: 8px;
    '>No ID specified.</div>";
}
?>
