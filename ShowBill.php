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

// Get current time
date_default_timezone_set('Asia/Kolkata'); // Set your timezone if needed
$formattedTime = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Inventory - Bill</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-image: url('your-background-image.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            margin: 0; 
            padding: 0; 
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
            background-color: white; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px 15px; 
            text-align: left; 
        }
        th { 
            background-color: #1DCD9F; 
            color: white; 
        }
        a { 
            text-decoration: none; 
            color: #00796b; 
        }
        a:hover { 
            text-decoration: underline; 
            color: #004d40; 
        }
        form { 
            margin: 20px auto; 
            max-width: 400px; 
            padding: 20px; 
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 5px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); 
        }
        label { 
            display: block; 
            margin-bottom: 10px; 
            color: #00796b; 
        }
        input[type="text"] { 
            width: 100%; 
            padding: 10px; 
            margin-bottom: 20px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        input[type="submit"] { 
            background-color: #00796b; 
            color: #fff; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        input[type="submit"]:hover { 
            background-color: #004d40; 
        }
    </style>
</head>
<body>
    <header>
        <h1>Medicine Inventory - Bill</h1>
    </header>
    <table>
        <tr>
            <th>Medicine Name</th>
            <th>Dr name</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Total</th>
        </tr>
        <?php
        $sql = "SELECT * FROM bill";
        $result = $conn->query($sql);
        $total = 0.0;

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $itemTotal = $row['total'];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rate']) . "</td>";
                echo "<td>" . htmlspecialchars($itemTotal) . "</td>";
                echo "</tr>";
                $total += $itemTotal;
            }
        } else {
            echo "<tr><td colspan='5'>No items in bill.</td></tr>";
        }
        ?>
        <tr>
            <td colspan="4">Total</td>
            <td><?php echo htmlspecialchars($total); ?></td>
        </tr>
    </table>
    <h2>Bill Details</h2>
    <form action="CostumerHistory.php" method="GET">
        <label for="name">Customer Name</label>
        <input type="text" id="name" name="name" required><br>

        <label for="drname">Doctor Name</label>
        <input type="text" id="drname" name="drname" required><br>

        <label>Total</label>
        <input type="text" name="total" value="<?php echo htmlspecialchars($total); ?>"><br>

        <label>Time</label>
        <input type="text" name="time" value="<?php echo htmlspecialchars($formattedTime); ?>"><br>

        <input type="submit" value="Pay">
    </form>
</body>
</html>
<?php
$conn->close();
?>
