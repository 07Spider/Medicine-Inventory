<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medicine";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $quantity = $expiry = $dosage = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : '';
    $expiry = isset($_POST["expiry"]) ? $_POST["expiry"] : '';
    $dosage = isset($_POST["dosage"]) ? $_POST["dosage"] : '';

    if ($name && $quantity && $expiry) {
        $stmt = $conn->prepare("INSERT INTO medicines (medicine_name, quantity, expiry_date, dosage_optional) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $name, $quantity, $expiry, $dosage);

        if ($stmt->execute()) {
            $success = "Medicine added successfully!";
        } else {
            $error = "Error adding medicine.";
        }

        $stmt->close();
    } else {
        $error = "Please fill all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Medicine</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1DCD9F;
        }

        label {
            display: block;
            margin: 12px 0 5px;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #444;
            background-color: #222;
            color: #fff;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            width: 100%;
            background: #1DCD9F;
            color: #000;
            padding: 12px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #169976;
        }

        .success, .error {
            text-align: center;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .success {
            color: #00e676;
        }

        .error {
            color: #ff5252;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Medicine</h2>

        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php elseif ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="name">Medicine Name*</label>
            <input type="text" id="name" name="name" required>

            <label for="quantity">Quantity*</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="expiry">Expiry Date*</label>
            <input type="date" id="expiry" name="expiry" required>

            <label for="dosage">Dosage (optional)</label>
            <input type="text" id="dosage" name="dosage">

            <input type="submit" value="Add Medicine">
        </form>
    </div>
</body>
</html>
