<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get the search term from the GET request
$sn = isset($_GET['searchname']) ? $_GET['searchname'] : '';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$sql = "SELECT 
    c.id,
    m.medicine_name, 
    c.brand, 
    c.quantity, 
    c.rate, 
    c.total
FROM cart c
JOIN medicines m ON c.name = m.medicine_name
WHERE m.medicine_name LIKE ?";

$stmt = $conn->prepare($sql);
$searchTerm = "%" . $sn . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Search</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #1D1D1D;
            color: #fff;
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            color: #1DCD9F;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            background-color: #333;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 14px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        th {
            background-color: #1DCD9F;
            color: #000;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #444;
        }

        a {
            color: #1DCD9F;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            color: #ffffff;
        }

        .back-button {
            display: inline-block;
            background-color: #169976;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 20px;
            transition: background 0.3s ease;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-button:hover {
            background-color: #1DCD9F;
        }

        .no-record {
            color: #ff4c4c;
            text-align: center;
            font-weight: bold;
            padding: 20px;
        }
    </style>
</head>
<body>
    <a href="try1.html" class="back-button">← Back</a>

    <h1>Medicine Search</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Medicine Name</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>Total</th>
            <th>Add Medicine</th>
            <th>Sell Medicine</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = htmlspecialchars($row['id']);
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>" . htmlspecialchars($row['medicine_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['rate']) . "</td>";
                echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                echo "<td><a href='ShowAddMedicine.php?id={$id}'>Add Medicine</a></td>";
                echo "<td><a href='ShowSellMedicine.php?id={$id}'>Sell Medicine</a></td>";
                echo "<td><a href='ShowEdit.php?id={$id}'>Edit</a></td>";
                echo "<td><a href='DeleteRecord.php?id={$id}'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10' class='no-record'>No results found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
