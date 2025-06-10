<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicines ORDER BY expiry_date ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medicine Inventory</title>
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
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 16px;
            max-width: 1100px;
            margin: auto;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            color: #1DCD9F;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #222;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 16px;
            text-align: center;
            border-bottom: 1px solid #444;
            color: #eee;
        }

        th {
            background-color: #1DCD9F;
            color: #000;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        .no-data {
            text-align: center;
            color: #ff4c4c;
            font-weight: 600;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <a href="try1.html" class="back-button">← Back</a>

    <div class="overlay">
        <h2>Medicine Inventory</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Expiry Date</th>
                    <th>Dosage</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= htmlspecialchars($row["medicine_name"]) ?></td>
                        <td><?= $row["quantity"] ?></td>
                        <td><?= date("d M Y", strtotime($row["expiry_date"])) ?></td>
                        <td><?= htmlspecialchars($row["dosage_optional"]) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p class="no-data">No medicines found in the inventory.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>
