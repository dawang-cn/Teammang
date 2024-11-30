<?php
include("setup.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create'])) {
        // Create a new service
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = $_POST['price'];
        $duration = $_POST['duration'];
        $type = $_POST['type'];
        $image_url = $_POST['image_url']; 
        
        $sql = "INSERT INTO services (name, description, price, duration, type, image_url) VALUES ('$name', '$description', '$price', '$duration', '$type', '$image_url')";
        if ($conn->query($sql) === TRUE) {
            echo "New service created successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Update an existing service
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $duration = $_POST['duration'];
        $type = $_POST['type'];
        $image_url = $_POST['image_url'];

        $sql = "UPDATE services SET name='$name', description='$description', price='$price', duration='$duration', type='$type', image_url='$image_url' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Service updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        // Delete a service
        $id = $_POST['id'];
        $sql = "DELETE FROM services WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Service deleted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Fetch all services for display
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
</head>
<body>
    <h1>Manage Services</h1>

    <form method="POST">
        <h2>Create Service</h2>
        <input type="text" name="name" placeholder="Service Name" required>
        <textarea name="description" placeholder="Service Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="number" name="duration" placeholder="Duration (minutes)"
