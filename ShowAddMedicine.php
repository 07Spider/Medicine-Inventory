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
    <title>Edit Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f2f1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 105, 92, 0.1);
            border: 1px solid #80cbc4;
        }
        h1 {
            text-align: center;
            color: #004d40;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #00695c;
        }
        input[type='text'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #b2dfdb;
            border-radius: 4px;
        }
        input[type='submit'] {
            background-color: #00796b;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type='submit']:hover {
            background-color: #004d40;
        }
        p {
            text-align: center;
            color: #00695c;
        }
    </style>
</head>
<body>
<div class='container'>
    <h1>Edit Record</h1>
    <?php
    if ($idParam !== '') {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("<p>Connection failed: " . $conn->connect_error . "</p>");
        }
        $stmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $stmt->bind_param("i", $idParam);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $name = htmlspecialchars($row['Name']);
            $brand = htmlspecialchars($row['Brand']);
            $quantity = (int)$row['Quantity'];
            $rate = (double)$row['Rate'];
            $total = $quantity * $rate;
            ?>
            <form method="get" action="AddMedicine.php">
                <input type="hidden" name="eid" value="<?php echo $idParam; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <label for="brand">Brand:</label>
                <input type="text" id="brand" name="brand" value="<?php echo $brand; ?>">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" value="<?php echo $quantity; ?>">
                <label for="newmedicine">New Medicine:</label>
                <input type="text" id="newmedicine" name="newmedicine"><br>
                <input type="hidden" name="rate" value="<?php echo $rate; ?>">
                <input type="hidden" name="total" value="<?php echo $total; ?>">
                <input type="submit" value="Update">
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
</div>
</body>
</html>
