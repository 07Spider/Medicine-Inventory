<?php
include 'db_connection.php';

$sql = "SELECT * FROM medicines WHERE quantity <= 0";
$result = $conn->query($sql);

echo "<h3>Out of Stock Medicines</h3>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 80%; margin: 20px auto; text-align: center;'>
            <tr style='background-color: #1DCD9F; color: white;'>
                <th>Name</th>
                <th>Expiry</th>
                <th>Dosage</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='background-color: #f4f4f4;'>
                <td>" . htmlspecialchars($row['medicine_name']) . "</td>
                <td>" . htmlspecialchars($row['expiry_date']) . "</td>
                <td>" . htmlspecialchars($row['dosage_optional']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color: green; font-size: 18px;'>🎉 All medicines are in stock!</p>";
}
?>
