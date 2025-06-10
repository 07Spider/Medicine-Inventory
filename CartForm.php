<?php
include 'db_connection.php';

// Check if all required GET parameters are set
if (isset($_GET['name'], $_GET['brand'], $_GET['quantity'], $_GET['rate'])) {
    $name = $_GET['name'];
    $brand = $_GET['brand'];

    // Validate and sanitize input
    $quantity = filter_var($_GET['quantity'], FILTER_VALIDATE_INT);
    $rate = filter_var($_GET['rate'], FILTER_VALIDATE_FLOAT);

    if ($quantity === false || $rate === false) {
        echo "<p style='color:#d9534f;'>❌ Invalid input for quantity or rate.</p>";  // Red for error
    } else {
        // Prepare and execute the insert statement
        $stmt = $conn->prepare("INSERT INTO cart (name, brand, quantity, rate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssid", $name, $brand, $quantity, $rate);

        if ($stmt->execute()) {
            echo "<p style='color:#00796b;'>🛒 Item added to cart successfully!</p>";  // Teal for success
        } else {
            echo "<p style='color:#d9534f;'>❌ Error: " . $stmt->error . "</p>";  // Red for error
        }

        $stmt->close();
    }
}
?>
<a href="CartForm.php" style="text-decoration: none; color: #00796b;">Back to Cart Form</a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cart Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #00796b;
        }

        input[type='text'], input[type='number'] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type='submit'] {
            background-color: #00796b;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            margin: 5px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        input[type='submit']:hover {
            background-color: #004d40;
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

        h1 {
            color: #00796b;
        }
    </style>
</head>
<body>

<a href='try1.html' class='back-button'>Back</a>

<h1>Cart Form</h1>

<form action="CartInsert.php" method="get">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" required><br><br>

    <label for="quantity">Quantity:</label>
    <input type="number" id="quantity" name="quantity" required><br><br>

    <label for="rate">Rate:</label>
    <input type="number" id="rate" name="rate" required><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
