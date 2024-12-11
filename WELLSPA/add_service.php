<?php
session_start();
include('setup.php');

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO services (service_name, description, price, duration) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssdi', $service_name, $description, $price, $duration);

    if ($stmt->execute()) {
        echo "Service added successfully!";
    } else {
        echo "Error adding service: " . $stmt->error;
    }
}
?>
