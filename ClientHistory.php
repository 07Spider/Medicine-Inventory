<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query
$sql = "SELECT * FROM history ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Client History</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('your-background-image.jpg'); /* Replace with your image path */
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
        }
        header {
            background-color: #00796b;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            margin: 20px 0;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 90%;
            margin: auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #1DCD9F;
            color: #fff;
        }
        a {
            text-decoration: none;
            color: #00796b;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
            color: #004d40;
        }
        .back-button {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px 15px;
            background-color: #00796b;
            color: #fff;
            border-radius: 4px;
            text-align: center;
        }
        .back-button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <header>
        <h1>Client History</h1>
    </header>
    <a href="try1.html" class="back-button">Back</a>
    <table>
        <tr>
            <th>Client Name</th>
            <th>Dr Name</th>
            <th>Bill Generated</th>
            <th>Time</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['drname']) . "</td>";
                echo "<td>Rs " . htmlspecialchars($row['brand']) . "</td>";
                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
