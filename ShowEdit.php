<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$idParam = isset($_GET['id']) ? $_GET['id'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: var(--primary-color);
            color: #fff;
            padding: 10px 0;
            margin: 0;
        }

        form {
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type='text'] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type='submit'] {
            background-color: var(--button-color);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type='submit']:hover {
            background-color: var(--button-hover-color);
        }
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

        // Prepare and execute the SQL statement to fetch record based on ID
        $stmt = $conn->prepare("SELECT * FROM cart WHERE id = ?");
        $stmt->bind_param("i", $idParam);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a record exists for the given ID
        if ($row = $result->fetch_assoc()) {
            // Assign values to variables from the fetched row
            $name = htmlspecialchars($row['Name']);
            $brand = htmlspecialchars($row['Brand']);
            $quantity = (int)$row['Quantity'];
            $rate = (float)$row['Rate'];
            $total = $quantity * $rate;
            ?>
            <!-- Form to edit the record -->
            <form method="get" action="ShowEditUpdate.php">
                <input type="hidden" name="eid" value="<?php echo htmlspecialchars($idParam); ?>">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>" required><br>
                <label for="brand">Brand:</label>
                <input type="text" name="brand" id="brand" value="<?php echo $brand; ?>" required><br>
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" id="quantity" value="<?php echo $quantity; ?>" required><br>
                <label for="rate">Rate:</label>
                <input type="text" name="rate" id="rate" value="<?php echo $rate; ?>" required><br>
                <input type="hidden" name="total" value="<?php echo $total; ?>"><br>
                <input type="submit" value="Edit">
            </form>
            <?php
        } else {
            echo "Record not found.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "No ID provided.";
    }
    ?>
</body>
</html>
