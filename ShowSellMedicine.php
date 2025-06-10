<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$idParam = isset($_GET['id']) ? $_GET['id'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f8f8; }
        h1 { background-color: #333; color: #fff; padding: 10px; text-align: center; }
        form { max-width: 400px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        label { font-weight: bold; }
        input[type='text'] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        input[type='submit'] { background-color: #333; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        input[type='submit']:hover { background-color: #555; }
    </style>
</head>
<body>
    <h1>Edit Record</h1>
    <?php
    if ($idParam !== '') {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $stmt->bind_param("i", $idParam);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars($row['Name']);
            $brand = htmlspecialchars($row['Brand']);
            $quantity = (int)$row['Quantity'];
            $rate = (float)$row['Rate'];
            $total = $quantity * $rate;
            ?>
            <form method="post" action="sellmedicine.php">
                <input type="hidden" name="eid" value="<?php echo $idParam; ?>">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>" disabled><br>
                <input type="hidden" name="brand" value="<?php echo $brand; ?>"><br>
                <label>Quantity:</label>
                <input type="text" name="quantity" value="<?php echo $quantity; ?>" disabled><br>
                <label>Sell Medicine:</label>
                <input type="text" name="sellmedicine" required><br>
                <label>Confirm Quantity:</label>
                <input type="text" name="billquantity" required><br>
                <input type="hidden" name="rate" value="<?php echo $rate; ?>"><br>
                <input type="hidden" name="total" value="<?php echo $total; ?>"><br>
                <input type="submit" value="Add On Bill">
            </form>
            <?php
        } else {
            echo "<p>Record not found.</p>";
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "<p>No ID provided.</p>";
    }
    ?>
</body>
</html>
