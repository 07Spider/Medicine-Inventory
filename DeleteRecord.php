<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$id = isset($_GET['id']) ? $_GET['id'] : '';

if ($id !== '') {
    $conn = new mysqli($servername, $username, $password, $dbname);
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

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();

    // Redirect to the "Show" page after deletion (success or failure)
    header("Location: Show.php");
    exit();

    $stmt->close();
    $conn->close();
} else {
    // If no ID provided, redirect to Show page
    header("Location: Show.php");
    exit();
}
?>
