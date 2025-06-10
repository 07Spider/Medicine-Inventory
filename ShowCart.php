<?php
// Database connection parameters
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

// Set content type
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f7fa; 
            text-align: center; 
            margin: 0; 
            padding: 0; 
        }
        h1 { 
            background-color: #00796b; 
            color: #fff; 
            padding: 10px 0; 
            margin-bottom: 20px; 
        }
        table { 
            border-collapse: collapse; 
            width: 70%; 
            margin: auto; 
            background-color: #fff; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        th { 
            background-color: #00796b; 
            color: white; 
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
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #004d40;
        }
    </style>
</head>
<body>
    <h1>Cart</h1>
    <a href="try1.html" class="back-button">Back</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Medicine Name</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Total</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        $sql = "SELECT * FROM cart";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Brand']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Rate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
                echo "<td><a href='ShowCartEdit.php?id=" . urlencode($row['ID']) . "'>Edit</a></td>";
                echo "<td><a href='DeleteCart.php?id=" . urlencode($row['ID']) . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No items in cart.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
