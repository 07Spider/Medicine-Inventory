<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get parameters from GET request
$eid = isset($_GET['eid']) ? $_GET['eid'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';
$stquantity = isset($_GET['quantity']) ? $_GET['quantity'] : '';
$strate = isset($_GET['rate']) ? $_GET['rate'] : '';

if ($eid && $name && $brand && $stquantity && $strate) {
    $quantity = intval($stquantity);
    $rate = floatval($strate);
    $total = $quantity * $rate;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("UPDATE cart SET name = ?, brand = ?, quantity = ?, rate = ?, total = ? WHERE id = ?");
    $stmt->bind_param("ssiddi", $name, $brand, $quantity, $rate, $total, $eid);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Redirect to ShowCart.php after successful update
        header("Location: ShowCart.php");
        exit();
    } else {
        echo "<h2>Record not found or update failed.</h2>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Missing required parameters.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>
    <style>
        /* Base Colors */
        :root {
            --primary-color: #009688;  /* Teal */
            --secondary-color: #004d40;  /* Dark Teal */
            --accent-color: #80cbc4;   /* Light Teal */
            --background-color: #f1f8f6; /* Very Light Teal */
            --text-color: #004d40;      /* Dark Text */
            --button-color: #00796b;    /* Darker Teal for Buttons */
            --button-hover-color: #004d40; /* Button Hover */
        }

        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Heading */
        h1 {
            text-align: center;
            color: var(--primary-color);
        }

        /* Form */
        form {
            text-align: left;
        }

        label {
            display: block;
            margin-top: 10px;
            color: var(--secondary-color);
        }

        input[type='text'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        /* Submit Button */
        input[type='submit'] {
            background-color: var(--button-color);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: var(--button-hover-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Record</h1>
        <?php
        if ($eid !== '') {
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL statement
            $stmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
            $stmt->bind_param("i", $eid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['Name']);
                $brand = htmlspecialchars($row['Brand']);
                $quantity = (int)$row['Quantity'];
                $rate = (double)$row['Rate'];
                $total = $quantity * $rate;
                ?>
                <form method="get" action="ShowCartUpdate.php">
                    <input type="hidden" name="eid" value="<?php echo htmlspecialchars($eid); ?>">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?php echo $name; ?>"><br>
                    <label>Brand:</label>
                    <input type="text" name="brand" value="<?php echo $brand; ?>"><br>
                    <label>Quantity:</label>
                    <input type="text" name="quantity" value="<?php echo $quantity; ?>"><br>
                    <label>Rate:</label>
                    <input type="text" name="rate" value="<?php echo $rate; ?>"><br>
                    <input type="hidden" name="total" value="<?php echo $total; ?>"><br>
                    <input type="submit" value="Update">
                </form>
                <?php
            } else {
                echo "Record not found.";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "No ID specified.";
        }
        ?>
    </div>
</body>
</html>
