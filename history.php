<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicines ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine History</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('https://img.freepik.com/free-photo/medical-stethoscope-health-care-blue-background-with-copy-space_53876-124044.jpg') no-repeat center center/cover;
            min-height: 100vh;
            padding: 40px 20px;
            color: #fff;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 16px;
            max-width: 1200px;
            margin: auto;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
        }

        h1 {
            text-align: center;
            color: #1DCD9F;
            margin-bottom: 25px;
            font-size: 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #222;
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
            background-color: #2a2a2a;
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
            position: absolute;
            top: 20px;
            left: 20px;
            transition: background 0.3s ease;
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

    <div class="overlay">
        <h1>Medicine History</h1>

        <table>
            <tr>
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
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['medicine_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['brand'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['rate'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['total'] ?? '') . "</td>";
                    echo "<td><a href='ShowAddMedicine.php?id=" . urlencode($row['id']) . "'>Add</a></td>";
                    echo "<td><a href='ShowSellMedicine.php?id=" . urlencode($row['id']) . "'>Sell</a></td>";
                    echo "<td><a href='ShowEdit.php?id=" . urlencode($row['id']) . "'>Edit</a></td>";
                    echo "<td><a href='DeleteRecord.php?id=" . urlencode($row['id']) . "'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='no-record'>No records found.</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
