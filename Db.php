<?php
$host = "localhost";     // Host name (usually localhost)
$user = "root";          // Username (default in XAMPP is 'root')
$password = "";          // Password (empty by default in XAMPP)
$database = "medicine";  // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Optional: You can uncomment this to confirm connection
// echo "✅ Connected successfully to 'medicine' database";
?>
