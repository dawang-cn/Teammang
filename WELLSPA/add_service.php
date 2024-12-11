<?php
include 'setup.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO services (service_name, description, price, duration) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $name, $description, $price, $duration);

    if ($stmt->execute()) {
        // Redirect to the services page
        header("Location: display_service.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #964B00;
            text-align: center;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #964B00;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #7a3c00;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Add New Service</h1>
    <form action="display_service.php" method="POST">
        <input type="text" name="name" required placeholder="Service Name">
        <textarea name="description" required placeholder="Service Description"></textarea>
        <input type="number" name="price" required placeholder="Service Price">
        <input type="text" name="duration" required placeholder="Service Duration (e.g., 1 hour)">
        <button type="submit">Add Service</button>
    </form>
</div>

</body>
</html>
