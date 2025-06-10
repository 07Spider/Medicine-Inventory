<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

// Get the id parameter from the GET request
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
        h1 {
            text-align: center;
            color: #004d40;
            margin-top: 40px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 105, 92, 0.1);
            border: 1px solid #80cbc4;
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
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        p {
            text-align: center;
            color: #00695c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Record</h1>
        <?php
        if ($idParam !== '') {
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute the SQL statement
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
                <form method="get" action="ShowCartUpdate.php">
                    <input type="hidden" name="eid" value="<?php echo htmlspecialchars($idParam); ?>">
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
