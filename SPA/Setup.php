<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // Update as needed
$password = ""; // Update as needed
$dbname = "spa";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db($dbname);

// Create Users Table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'admin') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully.<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create Services Table
$sql = "CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL, -- duration in minutes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Services table created successfully.<br>";
} else {
    echo "Error creating services table: " . $conn->error . "<br>";
}

// Create Appointments Table
$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'canceled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Appointments table created successfully.<br>";
} else {
    echo "Error creating appointments table: " . $conn->error . "<br>";
}

// Create Payments Table
$sql = "CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method ENUM('cash', 'card', 'online') DEFAULT 'cash',
    FOREIGN KEY (appointment_id) REFERENCES appointments(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Payments table created successfully.<br>";
} else {
    echo "Error creating payments table: " . $conn->error . "<br>";
}

// Create Availability Table
$sql = "CREATE TABLE IF NOT EXISTS availability (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (service_id) REFERENCES services(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Availability table created successfully.<br>";
} else {
    echo "Error creating availability table: " . $conn->error . "<br>";
}

// Create Reviews Table
$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Reviews table created successfully.<br>";
} else {
    echo "Error creating reviews table: " . $conn->error . "<br>";
}

// Create Promotions Table
$sql = "CREATE TABLE IF NOT EXISTS promotions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    discount_percentage DECIMAL(5, 2) NOT NULL,
    valid_from DATE NOT NULL,
    valid_to DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Promotions table created successfully.<br>";
} else {
    echo "Error creating promotions table: " . $conn->error . "<br>";
}

// Insert test data
$sql = "INSERT INTO users (name, email, password, role) VALUES
    ('John Doe', 'john@example.com', 'password123', 'customer'),
    ('Admin', 'admin@example.com', 'adminpass', 'admin')";
if ($conn->query($sql) === TRUE) {
    echo "Test data inserted into users table.<br>";
} else {
    echo "Error inserting test data into users table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>